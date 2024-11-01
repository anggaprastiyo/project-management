@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.ticketStatus.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.ticket-statuses.update", [$ticketStatus->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.ticketStatus.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $ticketStatus->name) }}" required>
                @if($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.ticketStatus.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="color">{{ trans('cruds.ticketStatus.fields.color') }}</label>
                <input class="form-control {{ $errors->has('color') ? 'is-invalid' : '' }}" type="text" name="color" id="color" value="{{ old('color', $ticketStatus->color) }}" required>
                @if($errors->has('color'))
                    <span class="text-danger">{{ $errors->first('color') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.ticketStatus.fields.color_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="order">{{ trans('cruds.ticketStatus.fields.order') }}</label>
                <input class="form-control {{ $errors->has('order') ? 'is-invalid' : '' }}" type="number" name="order" id="order" value="{{ old('order', $ticketStatus->order) }}" step="1" required>
                @if($errors->has('order'))
                    <span class="text-danger">{{ $errors->first('order') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.ticketStatus.fields.order_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('is_default') ? 'is-invalid' : '' }}">
                    <input class="form-check-input" type="checkbox" name="is_default" id="is_default" value="1" {{ $ticketStatus->is_default || old('is_default', 0) === 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_default">{{ trans('cruds.ticketStatus.fields.is_default') }}</label>
                </div>
                @if($errors->has('is_default'))
                    <span class="text-danger">{{ $errors->first('is_default') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.ticketStatus.fields.is_default_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection