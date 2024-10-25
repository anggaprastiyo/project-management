@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.project.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.projects.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.project.fields.id') }}
                        </th>
                        <td>
                            {{ $project->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.project.fields.team') }}
                        </th>
                        <td>
                            {{ App\Models\Project::TEAM_SELECT[$project->team] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.project.fields.cover_image') }}
                        </th>
                        <td>
                            @if($project->cover_image)
                                <a href="{{ $project->cover_image->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $project->cover_image->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.project.fields.name') }}
                        </th>
                        <td>
                            {{ $project->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.project.fields.ticket_prefix') }}
                        </th>
                        <td>
                            {{ $project->ticket_prefix }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.project.fields.project_owner') }}
                        </th>
                        <td>
                            {{ $project->project_owner->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.project.fields.project_status') }}
                        </th>
                        <td>
                            {{ $project->project_status->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.project.fields.description') }}
                        </th>
                        <td>
                            {!! $project->description !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.project.fields.type') }}
                        </th>
                        <td>
                            {{ App\Models\Project::TYPE_SELECT[$project->type] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.project.fields.status_type') }}
                        </th>
                        <td>
                            {{ App\Models\Project::STATUS_TYPE_SELECT[$project->status_type] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.project.fields.member') }}
                        </th>
                        <td>
                            @foreach($project->members as $key => $member)
                                <span class="label label-info">{{ $member->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.projects.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        {{ trans('global.relatedData') }}
    </div>
    <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
        <li class="nav-item">
            <a class="nav-link" href="#project_tickets" role="tab" data-toggle="tab">
                {{ trans('cruds.ticket.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#project_ticket_statuses" role="tab" data-toggle="tab">
                {{ trans('cruds.ticketStatus.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#project_meeting_notes" role="tab" data-toggle="tab">
                {{ trans('cruds.meetingNote.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="project_tickets">
            @includeIf('admin.projects.relationships.projectTickets', ['tickets' => $project->projectTickets])
        </div>
        <div class="tab-pane" role="tabpanel" id="project_ticket_statuses">
            @includeIf('admin.projects.relationships.projectTicketStatuses', ['ticketStatuses' => $project->projectTicketStatuses])
        </div>
        <div class="tab-pane" role="tabpanel" id="project_meeting_notes">
            @includeIf('admin.projects.relationships.projectMeetingNotes', ['meetingNotes' => $project->projectMeetingNotes])
        </div>
    </div>
</div>

@endsection