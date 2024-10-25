@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.ticketType.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.ticket-types.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.ticketType.fields.id') }}
                        </th>
                        <td>
                            {{ $ticketType->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.ticketType.fields.name') }}
                        </th>
                        <td>
                            {{ $ticketType->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.ticketType.fields.color') }}
                        </th>
                        <td>
                            {{ $ticketType->color }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.ticketType.fields.icon') }}
                        </th>
                        <td>
                            {{ $ticketType->icon }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.ticketType.fields.is_default') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $ticketType->is_default ? 'checked' : '' }}>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.ticket-types.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection