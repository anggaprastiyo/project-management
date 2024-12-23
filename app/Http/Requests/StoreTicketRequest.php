<?php

namespace App\Http\Requests;

use App\Models\Ticket;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreTicketRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('ticket_create');
    }

    public function rules()
    {
        return [
            'project_id' => [
                'required',
                'integer',
            ],
            'code' => [
                'string',
                'min:1',
                'max:10',
                'nullable',
            ],
            'name' => [
                'string',
                'min:1',
                'max:100',
                'required',
            ],
            'reporter_id' => [
                'nullable',
                'integer',
            ],
            'label' => [
                'string',
                'min:1',
                'max:20',
                'nullable',
            ],
            'content' => [
                'required',
            ],
            'point' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'attachment' => [
                'array',
            ],
            'design_link' => [
                'string',
                'nullable',
            ],
        ];
    }
}
