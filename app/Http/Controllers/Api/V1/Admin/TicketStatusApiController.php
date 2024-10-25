<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTicketStatusRequest;
use App\Http\Requests\UpdateTicketStatusRequest;
use App\Http\Resources\Admin\TicketStatusResource;
use App\Models\TicketStatus;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TicketStatusApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('ticket_status_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new TicketStatusResource(TicketStatus::with(['project'])->get());
    }

    public function store(StoreTicketStatusRequest $request)
    {
        $ticketStatus = TicketStatus::create($request->all());

        return (new TicketStatusResource($ticketStatus))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(TicketStatus $ticketStatus)
    {
        abort_if(Gate::denies('ticket_status_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new TicketStatusResource($ticketStatus->load(['project']));
    }

    public function update(UpdateTicketStatusRequest $request, TicketStatus $ticketStatus)
    {
        $ticketStatus->update($request->all());

        return (new TicketStatusResource($ticketStatus))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(TicketStatus $ticketStatus)
    {
        abort_if(Gate::denies('ticket_status_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $ticketStatus->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
