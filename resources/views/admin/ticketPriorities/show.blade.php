@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.ticketPriority.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.ticket-priorities.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.ticketPriority.fields.id') }}
                        </th>
                        <td>
                            {{ $ticketPriority->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.ticketPriority.fields.name') }}
                        </th>
                        <td>
                            {{ $ticketPriority->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.ticketPriority.fields.color') }}
                        </th>
                        <td>
                            {{ $ticketPriority->color }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.ticketPriority.fields.is_default') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $ticketPriority->is_default ? 'checked' : '' }}>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.ticket-priorities.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection