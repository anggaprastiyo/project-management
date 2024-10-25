<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyTicketTypeRequest;
use App\Http\Requests\StoreTicketTypeRequest;
use App\Http\Requests\UpdateTicketTypeRequest;
use App\Models\TicketType;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TicketTypeController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('ticket_type_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $ticketTypes = TicketType::all();

        return view('admin.ticketTypes.index', compact('ticketTypes'));
    }

    public function create()
    {
        abort_if(Gate::denies('ticket_type_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.ticketTypes.create');
    }

    public function store(StoreTicketTypeRequest $request)
    {
        $ticketType = TicketType::create($request->all());

        return redirect()->route('admin.ticket-types.index');
    }

    public function edit(TicketType $ticketType)
    {
        abort_if(Gate::denies('ticket_type_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.ticketTypes.edit', compact('ticketType'));
    }

    public function update(UpdateTicketTypeRequest $request, TicketType $ticketType)
    {
        $ticketType->update($request->all());

        return redirect()->route('admin.ticket-types.index');
    }

    public function show(TicketType $ticketType)
    {
        abort_if(Gate::denies('ticket_type_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.ticketTypes.show', compact('ticketType'));
    }

    public function destroy(TicketType $ticketType)
    {
        abort_if(Gate::denies('ticket_type_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $ticketType->delete();

        return back();
    }

    public function massDestroy(MassDestroyTicketTypeRequest $request)
    {
        $ticketTypes = TicketType::find(request('ids'));

        foreach ($ticketTypes as $ticketType) {
            $ticketType->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
