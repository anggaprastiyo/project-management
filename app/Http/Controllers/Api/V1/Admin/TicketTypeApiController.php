<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTicketTypeRequest;
use App\Http\Requests\UpdateTicketTypeRequest;
use App\Http\Resources\Admin\TicketTypeResource;
use App\Models\TicketType;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TicketTypeApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('ticket_type_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new TicketTypeResource(TicketType::all());
    }

    public function store(StoreTicketTypeRequest $request)
    {
        $ticketType = TicketType::create($request->all());

        return (new TicketTypeResource($ticketType))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(TicketType $ticketType)
    {
        abort_if(Gate::denies('ticket_type_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new TicketTypeResource($ticketType);
    }

    public function update(UpdateTicketTypeRequest $request, TicketType $ticketType)
    {
        $ticketType->update($request->all());

        return (new TicketTypeResource($ticketType))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(TicketType $ticketType)
    {
        abort_if(Gate::denies('ticket_type_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $ticketType->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
