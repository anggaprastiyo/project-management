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

class MeetingNotesController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('meeting_note_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $meetingNotes = MeetingNote::with(['project', 'participants'])->get();

        $projects = Project::get();

        $users = User::get();

        return view('admin.meetingNotes.index', compact('meetingNotes', 'projects', 'users'));
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
