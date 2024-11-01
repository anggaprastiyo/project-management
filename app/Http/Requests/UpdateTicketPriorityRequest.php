<?php

namespace App\Http\Requests;

use App\Models\TicketPriority;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateTicketPriorityRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('ticket_priority_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'min:1',
                'max:100',
                'required',
            ],
            'color' => [
                'string',
                'min:1',
                'max:10',
                'required',
            ],
            'is_default' => [
                'nullable',
            ],
        ];
    }
}
