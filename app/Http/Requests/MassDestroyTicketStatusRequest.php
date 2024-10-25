<?php

namespace App\Http\Requests;

use App\Models\TicketStatus;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyTicketStatusRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('ticket_status_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:ticket_statuses,id',
        ];
    }
}
