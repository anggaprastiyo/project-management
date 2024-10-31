<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyTicketStatusRequest;
use App\Http\Requests\StoreTicketStatusRequest;
use App\Http\Requests\UpdateTicketStatusRequest;
use App\Models\Project;
use App\Models\TicketStatus;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class TicketStatusController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('ticket_status_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = TicketStatus::with(['project'])->select(sprintf('%s.*', (new TicketStatus)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'ticket_status_show';
                $editGate      = 'ticket_status_edit';
                $deleteGate    = 'ticket_status_delete';
                $crudRoutePart = 'ticket-statuses';

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
            $table->editColumn('order', function ($row) {
                return $row->order ? $row->order : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        $projects = Project::get();

        return view('admin.ticketStatuses.index', compact('projects'));
    }

    public function create()
    {
        abort_if(Gate::denies('ticket_status_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $projects = Project::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.ticketStatuses.create', compact('projects'));
    }

    public function store(StoreTicketStatusRequest $request)
    {
        $ticketStatus = TicketStatus::create($request->all());

        return redirect()->route('admin.ticket-statuses.index');
    }

    public function edit(TicketStatus $ticketStatus)
    {
        abort_if(Gate::denies('ticket_status_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $projects = Project::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $ticketStatus->load('project');

        return view('admin.ticketStatuses.edit', compact('projects', 'ticketStatus'));
    }

    public function update(UpdateTicketStatusRequest $request, TicketStatus $ticketStatus)
    {
        $ticketStatus->update($request->all());

        return redirect()->route('admin.ticket-statuses.index');
    }

    public function show(TicketStatus $ticketStatus)
    {
        abort_if(Gate::denies('ticket_status_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $ticketStatus->load('project');

        return view('admin.ticketStatuses.show', compact('ticketStatus'));
    }

    public function destroy(TicketStatus $ticketStatus)
    {
        abort_if(Gate::denies('ticket_status_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $ticketStatus->delete();

        return back();
    }

    public function massDestroy(MassDestroyTicketStatusRequest $request)
    {
        $ticketStatuses = TicketStatus::find(request('ids'));

        foreach ($ticketStatuses as $ticketStatus) {
            $ticketStatus->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
