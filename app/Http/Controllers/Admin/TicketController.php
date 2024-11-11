<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyTicketRequest;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use App\Models\Project;
use App\Models\Ticket;
use App\Models\TicketPriority;
use App\Models\TicketStatus;
use App\Models\TicketType;
use App\Models\User;
use App\Services\ProjectServices;
use App\Services\TicketStatusServices;
use App\Services\UserServices;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class TicketController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('ticket_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // get only ticket that relate to user projects
        $user = Auth::user();
        $projects = ProjectServices::getAllProjectByUser($user);
        $projectIds = !is_null($projects) ? $projects->pluck('id') : [];

        if ($request->ajax()) {
            $query = Ticket::with(['project', 'reporter', 'assigne', 'status', 'type', 'priority', 'related_ticket'])
                ->select(sprintf('%s.*', (new Ticket)->table))
                ->orderBy('id', 'desc');

            if (count($projectIds) > 0) {
                $query->whereIn('tickets.project_id', $projectIds);
            }

            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'ticket_show';
                $editGate = 'ticket_edit';
                $deleteGate = 'ticket_delete';
                $crudRoutePart = 'tickets';

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
            $table->addColumn('project_name', function ($row) {
                return $row->project ? $row->project->name : '';
            });

            $table->editColumn('code', function ($row) {
                return $row->code ? $row->code : '';
            });
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : '';
            });
            $table->addColumn('assigne_name', function ($row) {
                return $row->assigne ? $row->assigne->name : '';
            });

            $table->addColumn('status_name', function ($row) {
                return $row->status ? $row->status->name : '';
            });

            $table->addColumn('type_name', function ($row) {
                return $row->type ? $row->type->name : '';
            });

            $table->addColumn('priority_name', function ($row) {
                return $row->priority ? $row->priority->name : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'project', 'assigne', 'status', 'type', 'priority']);

            return $table->make(true);
        }

        $projects = Project::whereIn('id', $projectIds)->get();
        $ticket_statuses = TicketStatusServices::generateTicketGroup($user);
        $ticket_types = TicketType::get();
        $ticket_priorities = TicketPriority::get();
        $tickets = Ticket::get();

        return view('admin.tickets.index', compact('projects', 'ticket_statuses', 'ticket_types', 'ticket_priorities', 'tickets'));
    }

    public function create(Request $request)
    {
        abort_if(Gate::denies('ticket_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user = Auth::user();
        $projectId = $request->input('project_id');
        $projects = null;
        $project = null;

        if (!is_null($projectId)) {
            $project = Project::where('uuid', $request->input('project_id'))->first();
            $assignes = UserServices::generateProjectMember($project->team, $project->project_owner->unit_code, $project->id);
            $related_tickets = Ticket::where('project_id', $project->id)->pluck('name', 'id');
        } else {
            $projects = ProjectServices::getAllProjectByUser($user);
            $assignes = null;
            $related_tickets = null;
        }

        $statuses = TicketStatusServices::generateTicketStatus($project);
        $types = TicketType::orderBy('is_default', 'desc')->pluck('name', 'id');
        $priorities = TicketPriority::orderBy('is_default', 'desc')->pluck('name', 'id');

        return view('admin.tickets.create', compact('assignes', 'priorities', 'related_tickets', 'statuses', 'types', 'project', 'projects'));
    }

    public function store(StoreTicketRequest $request)
    {
        try {

            $request['reporter_id'] = Auth::user()->id;
            $ticket = Ticket::create($request->all());

            foreach ($request->input('attachment', []) as $file) {
                $ticket->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('attachment');
            }

            if ($media = $request->input('ck-media', false)) {
                Media::whereIn('id', $media)->update(['model_id' => $ticket->id]);
            }

            toast('Success Add Data!','success');

        } catch (\Exception $exception) {
            toast($exception->getMessage(),'error');
        }

        // redirect
        if (!is_null($ticket->project_id)) {
            return redirect()->route('admin.projects.show', [
                'project' => $ticket->project->uuid,
                'active_tab' => 'project_tickets'
            ]);
        }

        return redirect()->route('admin.tickets.index');
    }

    public function edit($uuid)
    {
        abort_if(Gate::denies('ticket_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user = Auth::user();
        $ticket = Ticket::where('uuid', $uuid)->first();
        $projectId = $ticket->project_id;

        if (!is_null($projectId)) {
            $project = Project::where('id', $projectId)->first();
            $assignes = UserServices::generateProjectMember($project->team, $project->project_owner->unit_code, $project->id);
            $related_tickets = Ticket::where('project_id', $project->id)->pluck('name', 'id');
        } else {
            $projects = ProjectServices::getAllProjectByUser($user);
            $assignes = null;
            $related_tickets = null;
        }

        $statuses = TicketStatusServices::generateTicketStatus($project);
        $types = TicketType::orderBy('is_default', 'desc')->pluck('name', 'id');
        $priorities = TicketPriority::orderBy('is_default', 'desc')->pluck('name', 'id');
        $related_tickets = Ticket::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $ticket->load('project', 'reporter', 'assigne', 'status', 'type', 'priority', 'related_ticket');

        return view('admin.tickets.edit', compact('assignes', 'priorities', 'related_tickets', 'statuses', 'ticket', 'types', 'project'));
    }

    public function update(UpdateTicketRequest $request, Ticket $ticket)
    {
        try {
            $ticket->update($request->all());

            if (count($ticket->attachment) > 0) {
                foreach ($ticket->attachment as $media) {
                    if (!in_array($media->file_name, $request->input('attachment', []))) {
                        $media->delete();
                    }
                }
            }
            $media = $ticket->attachment->pluck('file_name')->toArray();
            foreach ($request->input('attachment', []) as $file) {
                if (count($media) === 0 || !in_array($file, $media)) {
                    $ticket->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('attachment');
                }
            }

            toast('Success Update Data!','success');

        } catch (\Exception $exception) {
            toast($exception->getMessage(),'error');
        }

        // redirect
        if (!is_null($ticket->project_id)) {
            return redirect()->route('admin.projects.show', [
                'project' => $ticket->project->uuid,
                'active_tab' => 'project_tickets'
            ]);
        }

        return redirect()->route('admin.tickets.index');
    }

    public function show($uuid)
    {
        abort_if(Gate::denies('ticket_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $ticket = Ticket::where('uuid', $uuid)->first();
        $ticket->load('project', 'reporter', 'assigne', 'status', 'type', 'priority', 'related_ticket', 'ticketComments');

        return view('admin.tickets.show', compact('ticket'));
    }

    public function destroy($uuid)
    {
        abort_if(Gate::denies('ticket_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        try {
            $ticket = Ticket::where('uuid', $uuid)->first();
            $ticket->delete();

            toast('Success Delete Data!','success');
        } catch (\Exception $exception) {
            toast($exception->getMessage(),'error');
        }

        // redirect
        if (!is_null($ticket->project_id)) {
            return redirect()->route('admin.projects.show', [
                'project' => $ticket->project->uuid,
                'active_tab' => 'project_tickets'
            ]);
        }

        return back();
    }

    public function massDestroy(MassDestroyTicketRequest $request)
    {
        $tickets = Ticket::find(request('ids'));

        foreach ($tickets as $ticket) {
            $ticket->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('ticket_create') && Gate::denies('ticket_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model = new Ticket();
        $model->id = $request->input('crud_id', 0);
        $model->exists = true;
        $media = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
