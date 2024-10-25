<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyTicketPriorityRequest;
use App\Http\Requests\StoreTicketPriorityRequest;
use App\Http\Requests\UpdateTicketPriorityRequest;
use App\Models\TicketPriority;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TicketPriorityController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('ticket_priority_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $ticketPriorities = TicketPriority::all();

        return view('admin.ticketPriorities.index', compact('ticketPriorities'));
    }

    public function create()
    {
        abort_if(Gate::denies('ticket_priority_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.ticketPriorities.create');
    }

    public function store(StoreTicketPriorityRequest $request)
    {
        $ticketPriority = TicketPriority::create($request->all());

        return redirect()->route('admin.ticket-priorities.index');
    }

    public function edit(TicketPriority $ticketPriority)
    {
        abort_if(Gate::denies('ticket_priority_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.ticketPriorities.edit', compact('ticketPriority'));
    }

    public function update(UpdateTicketPriorityRequest $request, TicketPriority $ticketPriority)
    {
        $ticketPriority->update($request->all());

        return redirect()->route('admin.ticket-priorities.index');
    }

    public function show(TicketPriority $ticketPriority)
    {
        abort_if(Gate::denies('ticket_priority_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.ticketPriorities.show', compact('ticketPriority'));
    }

    public function destroy(TicketPriority $ticketPriority)
    {
        abort_if(Gate::denies('ticket_priority_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $ticketPriority->delete();

        return back();
    }

    public function massDestroy(MassDestroyTicketPriorityRequest $request)
    {
        $ticketPriorities = TicketPriority::find(request('ids'));

        foreach ($ticketPriorities as $ticketPriority) {
            $ticketPriority->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
