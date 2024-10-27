<?php

namespace App\Http\Requests;

use App\Models\MeetingNote;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyMeetingNoteRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('meeting_note_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:meeting_notes,id',
        ];
    }
}
