<?php

namespace App\Http\Requests;

use App\Models\MeetingNote;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreMeetingNoteRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('meeting_note_create');
    }

    public function rules()
    {
        return [
            'project_id' => [
                'required',
                'integer',
            ],
            'meeting_date' => [
                'required',
                'date_format:' . config('panel.date_format'),
            ],
            'participants.*' => [
                'integer',
            ],
            'participants' => [
                'required',
                'array',
            ],
            'topic' => [
                'string',
                'required',
            ],
            'note' => [
                'required',
            ],
        ];
    }
}
