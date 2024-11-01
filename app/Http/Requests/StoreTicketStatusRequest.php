<?php

namespace App\Http\Requests;

use App\Models\TicketStatus;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreTicketStatusRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('ticket_status_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'min:1',
                'max:50',
                'required',
            ],
            'color' => [
                'string',
                'min:1',
                'max:10',
                'required',
            ],
            'order' => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'is_default' => [
                'nullable'
            ]
        ];
    }
}
