<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyMeetingNoteRequest;
use App\Http\Requests\StoreMeetingNoteRequest;
use App\Http\Requests\UpdateMeetingNoteRequest;
use App\Models\MeetingNote;
use App\Models\Project;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class MeetingNotesController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('meeting_note_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = MeetingNote::with(['project', 'participants'])->select(sprintf('%s.*', (new MeetingNote)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'meeting_note_show';
                $editGate      = 'meeting_note_edit';
                $deleteGate    = 'meeting_note_delete';
                $crudRoutePart = 'meeting-notes';

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

            $table->editColumn('participant', function ($row) {
                $labels = [];
                foreach ($row->participants as $participant) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $participant->name);
                }

                return implode(' ', $labels);
            });
            $table->editColumn('topic', function ($row) {
                return $row->topic ? $row->topic : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'project', 'participant']);

            return $table->make(true);
        }

        $projects = Project::get();
        $users    = User::get();

        return view('admin.meetingNotes.index', compact('projects', 'users'));
    }

    public function create()
    {
        abort_if(Gate::denies('meeting_note_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $projects = Project::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $participants = User::pluck('name', 'id');

        return view('admin.meetingNotes.create', compact('participants', 'projects'));
    }

    public function store(StoreMeetingNoteRequest $request)
    {
        $meetingNote = MeetingNote::create($request->all());
        $meetingNote->participants()->sync($request->input('participants', []));
        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $meetingNote->id]);
        }

        return redirect()->route('admin.meeting-notes.index');
    }

    public function edit(MeetingNote $meetingNote)
    {
        abort_if(Gate::denies('meeting_note_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $projects = Project::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $participants = User::pluck('name', 'id');

        $meetingNote->load('project', 'participants');

        return view('admin.meetingNotes.edit', compact('meetingNote', 'participants', 'projects'));
    }

    public function update(UpdateMeetingNoteRequest $request, MeetingNote $meetingNote)
    {
        $meetingNote->update($request->all());
        $meetingNote->participants()->sync($request->input('participants', []));

        return redirect()->route('admin.meeting-notes.index');
    }

    public function show(MeetingNote $meetingNote)
    {
        abort_if(Gate::denies('meeting_note_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $meetingNote->load('project', 'participants');

        return view('admin.meetingNotes.show', compact('meetingNote'));
    }

    public function destroy(MeetingNote $meetingNote)
    {
        abort_if(Gate::denies('meeting_note_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $meetingNote->delete();

        return back();
    }

    public function massDestroy(MassDestroyMeetingNoteRequest $request)
    {
        $meetingNotes = MeetingNote::find(request('ids'));

        foreach ($meetingNotes as $meetingNote) {
            $meetingNote->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('meeting_note_create') && Gate::denies('meeting_note_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new MeetingNote();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
