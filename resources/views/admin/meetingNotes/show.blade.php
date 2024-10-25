@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.meetingNote.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.meeting-notes.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.meetingNote.fields.id') }}
                        </th>
                        <td>
                            {{ $meetingNote->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.meetingNote.fields.project') }}
                        </th>
                        <td>
                            {{ $meetingNote->project->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.meetingNote.fields.meeting_date') }}
                        </th>
                        <td>
                            {{ $meetingNote->meeting_date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.meetingNote.fields.participant') }}
                        </th>
                        <td>
                            @foreach($meetingNote->participants as $key => $participant)
                                <span class="label label-info">{{ $participant->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.meetingNote.fields.topic') }}
                        </th>
                        <td>
                            {{ $meetingNote->topic }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.meetingNote.fields.note') }}
                        </th>
                        <td>
                            {!! $meetingNote->note !!}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.meeting-notes.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection