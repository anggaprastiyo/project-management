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

class TicketStatusController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('ticket_status_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $ticketStatuses = TicketStatus::with(['project'])->get();

        $projects = Project::get();

        return view('admin.ticketStatuses.index', compact('projects', 'ticketStatuses'));
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
