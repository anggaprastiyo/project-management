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
use Yajra\DataTables\Facades\DataTables;

class TicketTypeController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('ticket_type_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = TicketType::query()->select(sprintf('%s.*', (new TicketType)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'ticket_type_show';
                $editGate      = 'ticket_type_edit';
                $deleteGate    = 'ticket_type_delete';
                $crudRoutePart = 'ticket-types';

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
            $table->editColumn('icon', function ($row) {
                return $row->icon ? $row->icon : '';
            });
            $table->editColumn('is_default', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->is_default ? 'checked' : null) . '>';
            });

            $table->rawColumns(['actions', 'placeholder', 'is_default']);

            return $table->make(true);
        }

        return view('admin.ticketTypes.index');
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

    public function edit($uuid)
    {
        abort_if(Gate::denies('ticket_type_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $ticketType = TicketType::where('uuid', $uuid)->first();
        return view('admin.ticketTypes.edit', compact('ticketType'));
    }

    public function update(UpdateTicketTypeRequest $request, TicketType $ticketType)
    {
        $ticketType->update($request->all());

        return redirect()->route('admin.ticket-types.index');
    }

    public function show($uuid)
    {
        abort_if(Gate::denies('ticket_type_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $ticketType = TicketType::where('uuid', $uuid)->first();
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
