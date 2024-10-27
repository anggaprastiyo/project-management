@extends('layouts.admin')
@section('content')

  <div class="card card-primary">
    <div class="card-header">
      {{ trans('global.create') }} {{ trans('cruds.user.title_singular') }}
    </div>

    <form method="POST" action="{{ route("admin.users.store") }}" enctype="multipart/form-data">
      @csrf
      <div class="card-body">

        <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
              <label for="nik">{{ trans('cruds.user.fields.nik') }}</label>
              <input class="form-control {{ $errors->has('nik') ? 'is-invalid' : '' }}" type="text" name="nik" id="nik"
                     value="{{ old('nik', '') }}">
              @if($errors->has('nik'))
                <span class="text-danger">{{ $errors->first('nik') }}</span>
              @endif
              <span class="help-block">{{ trans('cruds.user.fields.nik_helper') }}</span>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group">
              <label class="required" for="name">{{ trans('cruds.user.fields.name') }}</label>
              <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name"
                     id="name" value="{{ old('name', '') }}" required>
              @if($errors->has('name'))
                <span class="text-danger">{{ $errors->first('name') }}</span>
              @endif
              <span class="help-block">{{ trans('cruds.user.fields.name_helper') }}</span>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
              <label for="unit_code">{{ trans('cruds.user.fields.unit_code') }}</label>
              <input class="form-control {{ $errors->has('unit_code') ? 'is-invalid' : '' }}" type="text"
                     name="unit_code" id="unit_code" value="{{ old('unit_code', '') }}">
              @if($errors->has('unit_code'))
                <span class="text-danger">{{ $errors->first('unit_code') }}</span>
              @endif
              <span class="help-block">{{ trans('cruds.user.fields.unit_code_helper') }}</span>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group">
              <label for="unit_name">{{ trans('cruds.user.fields.unit_name') }}</label>
              <input class="form-control {{ $errors->has('unit_name') ? 'is-invalid' : '' }}" type="text"
                     name="unit_name" id="unit_name" value="{{ old('unit_name', '') }}">
              @if($errors->has('unit_name'))
                <span class="text-danger">{{ $errors->first('unit_name') }}</span>
              @endif
              <span class="help-block">{{ trans('cruds.user.fields.unit_name_helper') }}</span>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
              <label for="job_position_code">{{ trans('cruds.user.fields.job_position_code') }}</label>
              <input class="form-control {{ $errors->has('job_position_code') ? 'is-invalid' : '' }}" type="text"
                     name="job_position_code" id="job_position_code" value="{{ old('job_position_code', '') }}">
              @if($errors->has('job_position_code'))
                <span class="text-danger">{{ $errors->first('job_position_code') }}</span>
              @endif
              <span class="help-block">{{ trans('cruds.user.fields.job_position_code_helper') }}</span>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group">
              <label for="job_position_text">{{ trans('cruds.user.fields.job_position_text') }}</label>
              <input class="form-control {{ $errors->has('job_position_text') ? 'is-invalid' : '' }}" type="text"
                     name="job_position_text" id="job_position_text" value="{{ old('job_position_text', '') }}">
              @if($errors->has('job_position_text'))
                <span class="text-danger">{{ $errors->first('job_position_text') }}</span>
              @endif
              <span class="help-block">{{ trans('cruds.user.fields.job_position_text_helper') }}</span>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
              <label class="required" for="email">{{ trans('cruds.user.fields.email') }}</label>
              <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email" name="email"
                     id="email" value="{{ old('email') }}" required>
              @if($errors->has('email'))
                <span class="text-danger">{{ $errors->first('email') }}</span>
              @endif
              <span class="help-block">{{ trans('cruds.user.fields.email_helper') }}</span>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group">
              <label class="required" for="password">{{ trans('cruds.user.fields.password') }}</label>
              <input class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" type="password"
                     name="password" id="password" required>
              @if($errors->has('password'))
                <span class="text-danger">{{ $errors->first('password') }}</span>
              @endif
              <span class="help-block">{{ trans('cruds.user.fields.password_helper') }}</span>
            </div>
          </div>
        </div>

        <div class="form-group">
          <label class="required" for="roles">{{ trans('cruds.user.fields.roles') }}</label>
          <div style="padding-bottom: 4px">
            <span class="btn btn-info btn-xs select-all"
                  style="border-radius: 0">{{ trans('global.select_all') }}</span>
            <span class="btn btn-info btn-xs deselect-all"
                  style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
          </div>
          <select class="form-control select2 {{ $errors->has('roles') ? 'is-invalid' : '' }}" name="roles[]" id="roles"
                  multiple required>
            @foreach($roles as $id => $role)
              <option value="{{ $id }}" {{ in_array($id, old('roles', [])) ? 'selected' : '' }}>{{ $role }}</option>
            @endforeach
          </select>
          @if($errors->has('roles'))
            <span class="text-danger">{{ $errors->first('roles') }}</span>
          @endif
          <span class="help-block">{{ trans('cruds.user.fields.roles_helper') }}</span>
        </div>
      </div>
      <div class="card-footer">
        <button class="btn btn-primary btn-sm" type="submit">
          <i class="fa-fw nav-icon fas fa-check"></i> {{ trans('global.save') }}
        </button>
        <a href="{{route('admin.users.index')}}" class="btn btn-danger btn-sm">
          <i class="fa-fw nav-icon fas fa-times"></i> Cancel</a>
      </div>
    </form>
  </div>

@endsection