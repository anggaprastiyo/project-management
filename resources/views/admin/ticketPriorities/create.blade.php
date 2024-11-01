@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.ticketPriority.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.ticket-priorities.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.ticketPriority.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                @if($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.ticketPriority.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="color">{{ trans('cruds.ticketPriority.fields.color') }}</label>
                <input class="form-control col-md-1 {{ $errors->has('color') ? 'is-invalid' : '' }}" type="color" name="color" id="color" value="{{ old('color', '') }}" required>
                @if($errors->has('color'))
                    <span class="text-danger">{{ $errors->first('color') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.ticketPriority.fields.color_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('is_default') ? 'is-invalid' : '' }}">
                    <input class="form-check-input" type="checkbox" name="is_default" id="is_default" value="1" {{ old('is_default', 0) == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_default">{{ trans('cruds.ticketPriority.fields.is_default') }}</label>
                </div>
                @if($errors->has('is_default'))
                    <span class="text-danger">{{ $errors->first('is_default') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.ticketPriority.fields.is_default_helper') }}</span>
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