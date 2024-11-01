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
use Yajra\DataTables\Facades\DataTables;

class TicketPriorityController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('ticket_priority_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = TicketPriority::query()->select(sprintf('%s.*', (new TicketPriority)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'ticket_priority_show';
                $editGate      = 'ticket_priority_edit';
                $deleteGate    = 'ticket_priority_delete';
                $crudRoutePart = 'ticket-priorities';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : '';
            });
            $table->editColumn('color', function ($row) {
                return $row->color ? $row->color : '';
            });
            $table->editColumn('is_default', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->is_default ? 'checked' : null) . '>';
            });

            $table->rawColumns(['actions', 'placeholder', 'is_default']);

            return $table->make(true);
        }

        return view('admin.ticketPriorities.index');
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

    public function edit($uuid)
    {
        abort_if(Gate::denies('ticket_priority_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $ticketPriority = TicketPriority::where('uuid', $uuid)->first();

        return view('admin.ticketPriorities.edit', compact('ticketPriority'));
    }

    public function update(UpdateTicketPriorityRequest $request, TicketPriority $ticketPriority)
    {
        $ticketPriority->update($request->all());

        return redirect()->route('admin.ticket-priorities.index');
    }

    public function show($uuid)
    {
        abort_if(Gate::denies('ticket_priority_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $ticketPriority = TicketPriority::where('uuid', $uuid)->first();
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
