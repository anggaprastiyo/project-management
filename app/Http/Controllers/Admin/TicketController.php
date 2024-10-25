<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyTicketRequest;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use App\Models\Project;
use App\Models\Ticket;
use App\Models\TicketPriority;
use App\Models\TicketStatus;
use App\Models\TicketType;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class TicketController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('ticket_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $tickets = Ticket::get();

        $projects = Project::get();

        $users = User::get();

        $ticket_statuses = TicketStatus::get();

        $ticket_types = TicketType::get();

        $ticket_priorities = TicketPriority::get();

        return view('admin.tickets.index', compact('projects', 'ticket_priorities', 'ticket_statuses', 'ticket_types', 'tickets', 'users'));
    }

    public function create()
    {
        abort_if(Gate::denies('ticket_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $projects = Project::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $reporters = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $assignes = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $statuses = TicketStatus::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $types = TicketType::pluck('uuid', 'id')->prepend(trans('global.pleaseSelect'), '');

        $priorities = TicketPriority::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $related_tickets = Ticket::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.tickets.create', compact('assignes', 'priorities', 'projects', 'related_tickets', 'reporters', 'statuses', 'types'));
    }

    public function store(StoreTicketRequest $request)
    {
        $ticket = Ticket::create($request->all());

        foreach ($request->input('attachment', []) as $file) {
            $ticket->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('attachment');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $ticket->id]);
        }

        return redirect()->route('admin.tickets.index');
    }

    public function edit(Ticket $ticket)
    {
        abort_if(Gate::denies('ticket_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $projects = Project::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $reporters = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $assignes = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $statuses = TicketStatus::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $types = TicketType::pluck('uuid', 'id')->prepend(trans('global.pleaseSelect'), '');

        $priorities = TicketPriority::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $related_tickets = Ticket::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $ticket->load('project', 'reporter', 'assigne', 'status', 'type', 'priority', 'related_ticket');

        return view('admin.tickets.edit', compact('assignes', 'priorities', 'projects', 'related_tickets', 'reporters', 'statuses', 'ticket', 'types'));
    }

    public function update(UpdateTicketRequest $request, Ticket $ticket)
    {
        $ticket->update($request->all());

        if (count($ticket->attachment) > 0) {
            foreach ($ticket->attachment as $media) {
                if (! in_array($media->file_name, $request->input('attachment', []))) {
                    $media->delete();
                }
            }
        }
        $media = $ticket->attachment->pluck('file_name')->toArray();
        foreach ($request->input('attachment', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $ticket->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('attachment');
            }
        }

        return redirect()->route('admin.tickets.index');
    }

    public function show(Ticket $ticket)
    {
        abort_if(Gate::denies('ticket_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $ticket->load('project', 'reporter', 'assigne', 'status', 'type', 'priority', 'related_ticket', 'ticketComments');

        return view('admin.tickets.show', compact('ticket'));
    }

    public function destroy(Ticket $ticket)
    {
        abort_if(Gate::denies('ticket_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $ticket->delete();

        return back();
    }

    public function massDestroy(MassDestroyTicketRequest $request)
    {
        $tickets = Ticket::find(request('ids'));

        foreach ($tickets as $ticket) {
            $ticket->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('ticket_create') && Gate::denies('ticket_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Ticket();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
