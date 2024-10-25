<?php

namespace App\Http\Requests;

use App\Models\TicketType;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreTicketTypeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('ticket_type_create');
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
            'icon' => [
                'string',
                'min:1',
                'max:50',
                'required',
            ],
        ];
    }
}
