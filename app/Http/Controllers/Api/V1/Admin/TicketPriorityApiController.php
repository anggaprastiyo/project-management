<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTicketPriorityRequest;
use App\Http\Requests\UpdateTicketPriorityRequest;
use App\Http\Resources\Admin\TicketPriorityResource;
use App\Models\TicketPriority;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TicketPriorityApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('ticket_priority_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new TicketPriorityResource(TicketPriority::all());
    }

    public function store(StoreTicketPriorityRequest $request)
    {
        $ticketPriority = TicketPriority::create($request->all());

        return (new TicketPriorityResource($ticketPriority))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(TicketPriority $ticketPriority)
    {
        abort_if(Gate::denies('ticket_priority_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new TicketPriorityResource($ticketPriority);
    }

    public function update(UpdateTicketPriorityRequest $request, TicketPriority $ticketPriority)
    {
        $ticketPriority->update($request->all());

        return (new TicketPriorityResource($ticketPriority))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(TicketPriority $ticketPriority)
    {
        abort_if(Gate::denies('ticket_priority_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $ticketPriority->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
