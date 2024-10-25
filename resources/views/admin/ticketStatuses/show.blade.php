@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.ticketStatus.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.ticket-statuses.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.ticketStatus.fields.id') }}
                        </th>
                        <td>
                            {{ $ticketStatus->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.ticketStatus.fields.project') }}
                        </th>
                        <td>
                            {{ $ticketStatus->project->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.ticketStatus.fields.name') }}
                        </th>
                        <td>
                            {{ $ticketStatus->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.ticketStatus.fields.color') }}
                        </th>
                        <td>
                            {{ $ticketStatus->color }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.ticketStatus.fields.order') }}
                        </th>
                        <td>
                            {{ $ticketStatus->order }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.ticket-statuses.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection