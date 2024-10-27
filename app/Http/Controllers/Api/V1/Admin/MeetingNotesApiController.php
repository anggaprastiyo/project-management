<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreMeetingNoteRequest;
use App\Http\Requests\UpdateMeetingNoteRequest;
use App\Http\Resources\Admin\MeetingNoteResource;
use App\Models\MeetingNote;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MeetingNotesApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('meeting_note_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new MeetingNoteResource(MeetingNote::with(['project', 'participants'])->get());
    }

    public function store(StoreMeetingNoteRequest $request)
    {
        $meetingNote = MeetingNote::create($request->all());
        $meetingNote->participants()->sync($request->input('participants', []));

        return (new MeetingNoteResource($meetingNote))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(MeetingNote $meetingNote)
    {
        abort_if(Gate::denies('meeting_note_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new MeetingNoteResource($meetingNote->load(['project', 'participants']));
    }

    public function update(UpdateMeetingNoteRequest $request, MeetingNote $meetingNote)
    {
        $meetingNote->update($request->all());
        $meetingNote->participants()->sync($request->input('participants', []));

        return (new MeetingNoteResource($meetingNote))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(MeetingNote $meetingNote)
    {
        abort_if(Gate::denies('meeting_note_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $meetingNote->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
