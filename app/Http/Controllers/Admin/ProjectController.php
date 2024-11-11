<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyProjectRequest;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Project;
use App\Models\ProjectStatus;
use App\Models\TicketStatus;
use App\Models\User;
use App\Services\UserServices;
use Carbon\Carbon;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class ProjectController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('project_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {  
            $query = Project::with(['project_owner', 'project_status', 'members'])
                ->select(sprintf('%s.*', (new Project)->table))
                ->orderBy('id', 'desc');

            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'project_show';
                $editGate      = 'project_edit';
                $deleteGate    = 'project_delete';
                $crudRoutePart = 'projects';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->editColumn('team', function ($row) {
                return $row->team ? Project::TEAM_SELECT[$row->team] : '';
            });
            $table->editColumn('cover_image', function ($row) {
                if ($photo = $row->cover_image) {
                    return sprintf(
                        '<a href="%s" target="_blank"><img src="%s" width="50px" height="50px"></a>',
                        $photo->url,
                        $photo->thumbnail
                    );
                }

                return '';
            });
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : '';
            });
            $table->editColumn('ticket_prefix', function ($row) {
                return $row->ticket_prefix ? $row->ticket_prefix : '';
            });
            $table->addColumn('project_owner_name', function ($row) {
                return $row->project_owner ? $row->project_owner->name : '';
            });

            $table->addColumn('project_status_name', function ($row) {
                return $row->project_status ? $row->project_status->name : '';
            });

            $table->editColumn('type', function ($row) {
                return $row->type ? Project::TYPE_SELECT[$row->type] : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'cover_image', 'project_owner', 'project_status']);

            return $table->make(true);
        }

        $project_statuses = ProjectStatus::get();

        return view('admin.projects.index', compact( 'project_statuses'));
    }

    public function create()
    {
        abort_if(Gate::denies('project_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user = Auth::user();
        $project_owners = User::where('id', $user->id)
            ->pluck('name', 'id')
            ->prepend(trans('global.pleaseSelect'), '');

        $project_statuses = ProjectStatus::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.projects.create', compact('project_owners', 'project_statuses'));
    }

    public function store(StoreProjectRequest $request)
    {
        $project = Project::create($request->all());
        $project->members()->sync($request->input('members', []));
        if ($request->input('cover_image', false)) {
            $project->addMedia(storage_path('tmp/uploads/' . basename($request->input('cover_image'))))->toMediaCollection('cover_image');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $project->id]);
        }

        // create ticket status on project by status type
        $statusType = $request->input('status_type');
        if ($statusType == 'default') {
            $defaultTickets = TicketStatus::whereNull('project_id')
                ->whereNull('deleted_at')
                ->select(['name', 'color', 'order', 'is_default'])
                ->get();

            foreach ($defaultTickets as $defaultTickets) {
                $defaultTickets->project_id = $project->id;
                $defaultTickets->created_at = Carbon::now();
                TicketStatus::create($defaultTickets->toArray());
            }
        }

        return redirect()->route('admin.projects.index');
    }

    public function edit($uuid)
    {
        abort_if(Gate::denies('project_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $project_statuses = ProjectStatus::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $project = Project::where('uuid', $uuid)->first();
        $members = UserServices::generateProjectMember($project->team, $project->project_owner->unit_code);
        $project->load('project_owner', 'project_status', 'members');

        $isProjectAlreadyHaveTicket = $project->projectTickets->count() > 0 ? false : true;

        return view('admin.projects.edit', compact('members', 'project', 'project_statuses', 'isProjectAlreadyHaveTicket'));
    }

    public function update(UpdateProjectRequest $request, Project $project)
    {
        $project->update($request->all());
        $project->members()->sync($request->input('members', []));
        if ($request->input('cover_image', false)) {
            if (! $project->cover_image || $request->input('cover_image') !== $project->cover_image->file_name) {
                if ($project->cover_image) {
                    $project->cover_image->delete();
                }
                $project->addMedia(storage_path('tmp/uploads/' . basename($request->input('cover_image'))))->toMediaCollection('cover_image');
            }
        } elseif ($project->cover_image) {
            $project->cover_image->delete();
        }

        return redirect()->route('admin.projects.index');
    }

    public function show(Request $request, $uuid)
    {
        abort_if(Gate::denies('project_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $project = Project::where('uuid', $uuid)->first();
        $project->load('project_owner', 'project_status', 'members', 'projectTickets', 'projectTicketStatuses', 'projectMeetingNotes');
        $activeTab = !is_null($request->query('active_tab')) ? $request->query('active_tab') : 'project_tickets';

        return view('admin.projects.show', compact('project', 'activeTab'));
    }

    public function destroy(Project $project)
    {
        abort_if(Gate::denies('project_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $project->delete();

        return back();
    }

    public function massDestroy(MassDestroyProjectRequest $request)
    {
        $projects = Project::find(request('ids'));

        foreach ($projects as $project) {
            $project->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('project_create') && Gate::denies('project_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Project();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }

    public function getMember(Request $request)
    {
        $this->validate($request, [
            'type' => 'required',
            'project_id' => 'nullable|exists:projects,id'
        ]);

        // type input
        $type = $request->input('type');
        $projectId = $request->input('project_id');
        $user = Auth::user();

        // generate members
        $members = UserServices::generateProjectMember($type, $user->unit_code, $projectId);

        return response()->json($members, Response::HTTP_OK);
    }
}
