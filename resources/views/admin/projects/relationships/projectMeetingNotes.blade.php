<div class="m-3">
    @can('meeting_note_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-primary" href="{{ route('admin.meeting-notes.create') }}">
                    <i class="fa-fw nav-icon fas fa-plus"></i> {{ trans('global.add') }} {{ trans('cruds.meetingNote.title_singular') }}
                </a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.meetingNote.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-projectMeetingNotes">
                    <thead>
                        <tr>
                            <th width="10">

                            </th>
                            <th>
                                {{ trans('cruds.meetingNote.fields.id') }}
                            </th>
                            <th>
                                {{ trans('cruds.meetingNote.fields.project') }}
                            </th>
                            <th>
                                {{ trans('cruds.meetingNote.fields.meeting_date') }}
                            </th>
                            <th>
                                {{ trans('cruds.meetingNote.fields.participant') }}
                            </th>
                            <th>
                                {{ trans('cruds.meetingNote.fields.topic') }}
                            </th>
                            <th>
                                &nbsp;
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($meetingNotes as $key => $meetingNote)
                            <tr data-entry-id="{{ $meetingNote->id }}">
                                <td>

                                </td>
                                <td>
                                    {{ $meetingNote->id ?? '' }}
                                </td>
                                <td>
                                    {{ $meetingNote->project->name ?? '' }}
                                </td>
                                <td>
                                    {{ $meetingNote->meeting_date ?? '' }}
                                </td>
                                <td>
                                    @foreach($meetingNote->participants as $key => $item)
                                        <span class="badge badge-info">{{ $item->name }}</span>
                                    @endforeach
                                </td>
                                <td>
                                    {{ $meetingNote->topic ?? '' }}
                                </td>
                                <td>
                                    @can('meeting_note_show')
                                        <a class="btn btn-xs btn-primary" href="{{ route('admin.meeting-notes.show', $meetingNote->id) }}">
                                            {{ trans('global.view') }}
                                        </a>
                                    @endcan

                                    @can('meeting_note_edit')
                                        <a class="btn btn-xs btn-info" href="{{ route('admin.meeting-notes.edit', $meetingNote->id) }}">
                                            {{ trans('global.edit') }}
                                        </a>
                                    @endcan

                                    @can('meeting_note_delete')
                                        <form action="{{ route('admin.meeting-notes.destroy', $meetingNote->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                        </form>
                                    @endcan

                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('meeting_note_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.meeting-notes.massDestroy') }}",
    className: 'btn-danger btn-xs',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-projectMeetingNotes:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection