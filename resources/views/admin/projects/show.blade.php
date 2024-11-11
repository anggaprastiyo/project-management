@extends('layouts.admin')
@section('content')

<div class="invoice p-3 mb-3">
    <!-- title row -->
    <div class="row">
        <div class="col-12">
            <h4>
                {{$project->name}} - {{ $project->ticket_prefix }}
                <small class="float-right">
                    <span class="badge badge-info">{{ App\Models\Project::TYPE_SELECT[$project->type] ?? '' }}</span>
                    <span class="badge" style="background-color: {{$project->project_status->color}}">{{ $project->project_status->name ?? '' }}</span>
                </small>
            </h4>
        </div>
        <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">
        <div class="col-sm-12 invoice-col">
            <address>
                <strong>
                    <i class="fa fa-user"></i> {{ $project->project_owner->name ?? '' }}
                </strong>
            </address>
            {!! $project->description ?? '' !!}
        </div>
    </div>
    <!-- /.row -->
</div>

<div class="card">
    <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
        <li class="nav-item">
            <a class="nav-link {{ $activeTab == 'project_tickets' ? 'active show' : '' }}" href="#project_tickets" role="tab" data-toggle="tab">
                {{ trans('cruds.ticket.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $activeTab == 'project_ticket_statuses' ? 'active show' : '' }}" href="#project_ticket_statuses" role="tab" data-toggle="tab">
                {{ trans('cruds.ticketStatus.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $activeTab == 'members' ? 'active show' : '' }}" href="#members" role="tab" data-toggle="tab">
                {{ trans('cruds.project.fields.member') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $activeTab == 'project_meeting_notes' ? 'active show' : '' }}" href="#project_meeting_notes" role="tab" data-toggle="tab">
                {{ trans('cruds.meetingNote.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane {{ $activeTab == 'project_tickets' ? 'active show' : '' }}" role="tabpanel" id="project_tickets">
            @includeIf('admin.projects.relationships.projectTickets', ['tickets' => $project->projectTickets])
        </div>
        <div class="tab-pane {{ $activeTab == 'project_ticket_statuses' ? 'active show' : '' }}" role="tabpanel" id="project_ticket_statuses">
            @includeIf('admin.projects.relationships.projectTicketStatuses', ['ticketStatuses' => $project->projectTicketStatuses])
        </div>
        <div class="tab-pane {{ $activeTab == 'members' ? 'active show' : '' }}" role="tabpanel" id="members">
            @includeIf('admin.projects.relationships.projectMembers', ['members' => $project->members])
        </div>
        <div class="tab-pane {{ $activeTab == 'project_meeting_notes' ? 'active show' : '' }}" role="tabpanel" id="project_meeting_notes">
            @includeIf('admin.projects.relationships.projectMeetingNotes', ['meetingNotes' => $project->projectMeetingNotes])
        </div>
    </div>
</div>

@endsection