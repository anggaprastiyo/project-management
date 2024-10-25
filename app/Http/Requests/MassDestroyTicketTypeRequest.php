<?php

namespace App\Http\Requests;

use App\Models\TicketType;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyTicketTypeRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('ticket_type_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:ticket_types,id',
        ];
    }
}
