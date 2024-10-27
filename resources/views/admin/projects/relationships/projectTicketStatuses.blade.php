<div class="m-3">
    @can('ticket_status_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-primary" href="{{ route('admin.ticket-statuses.create') }}">
                    <i class="fa-fw nav-icon fas fa-plus"></i> {{ trans('global.add') }} {{ trans('cruds.ticketStatus.title_singular') }}
                </a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.ticketStatus.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-projectTicketStatuses">
                    <thead>
                        <tr>
                            <th width="10">

                            </th>
                            <th>
                                {{ trans('cruds.ticketStatus.fields.id') }}
                            </th>
                            <th>
                                {{ trans('cruds.ticketStatus.fields.name') }}
                            </th>
                            <th>
                                {{ trans('cruds.ticketStatus.fields.color') }}
                            </th>
                            <th>
                                {{ trans('cruds.ticketStatus.fields.order') }}
                            </th>
                            <th>
                                &nbsp;
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ticketStatuses as $key => $ticketStatus)
                            <tr data-entry-id="{{ $ticketStatus->id }}">
                                <td>

                                </td>
                                <td>
                                    {{ $ticketStatus->id ?? '' }}
                                </td>
                                <td>
                                    {{ $ticketStatus->name ?? '' }}
                                </td>
                                <td>
                                    {{ $ticketStatus->color ?? '' }}
                                </td>
                                <td>
                                    {{ $ticketStatus->order ?? '' }}
                                </td>
                                <td>
                                    @can('ticket_status_show')
                                        <a class="btn btn-xs btn-primary" href="{{ route('admin.ticket-statuses.show', $ticketStatus->id) }}">
                                            {{ trans('global.view') }}
                                        </a>
                                    @endcan

                                    @can('ticket_status_edit')
                                        <a class="btn btn-xs btn-info" href="{{ route('admin.ticket-statuses.edit', $ticketStatus->id) }}">
                                            {{ trans('global.edit') }}
                                        </a>
                                    @endcan

                                    @can('ticket_status_delete')
                                        <form action="{{ route('admin.ticket-statuses.destroy', $ticketStatus->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('ticket_status_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.ticket-statuses.massDestroy') }}",
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
  let table = $('.datatable-projectTicketStatuses:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection