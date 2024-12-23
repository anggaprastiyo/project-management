<div class="m-3">
    @can('ticket_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.tickets.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.ticket.title_singular') }}
                </a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.ticket.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-assigneTickets">
                    <thead>
                        <tr>
                            <th width="10">

                            </th>
                            <th>
                                {{ trans('cruds.ticket.fields.id') }}
                            </th>
                            <th>
                                {{ trans('cruds.ticket.fields.project') }}
                            </th>
                            <th>
                                {{ trans('cruds.ticket.fields.code') }}
                            </th>
                            <th>
                                {{ trans('cruds.ticket.fields.name') }}
                            </th>
                            <th>
                                {{ trans('cruds.ticket.fields.assigne') }}
                            </th>
                            <th>
                                {{ trans('cruds.ticket.fields.status') }}
                            </th>
                            <th>
                                {{ trans('cruds.ticket.fields.type') }}
                            </th>
                            <th>
                                {{ trans('cruds.ticket.fields.priority') }}
                            </th>
                            <th>
                                &nbsp;
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tickets as $key => $ticket)
                            <tr data-entry-id="{{ $ticket->id }}">
                                <td>

                                </td>
                                <td>
                                    {{ $ticket->id ?? '' }}
                                </td>
                                <td>
                                    {{ $ticket->project->name ?? '' }}
                                </td>
                                <td>
                                    {{ $ticket->code ?? '' }}
                                </td>
                                <td>
                                    {{ $ticket->name ?? '' }}
                                </td>
                                <td>
                                    {{ $ticket->assigne->name ?? '' }}
                                </td>
                                <td>
                                    {{ $ticket->status->name ?? '' }}
                                </td>
                                <td>
                                    {{ $ticket->type->uuid ?? '' }}
                                </td>
                                <td>
                                    {{ $ticket->priority->name ?? '' }}
                                </td>
                                <td>
                                    @can('ticket_show')
                                        <a class="btn btn-xs btn-primary" href="{{ route('admin.tickets.show', $ticket->id) }}">
                                            {{ trans('global.view') }}
                                        </a>
                                    @endcan

                                    @can('ticket_edit')
                                        <a class="btn btn-xs btn-info" href="{{ route('admin.tickets.edit', $ticket->id) }}">
                                            {{ trans('global.edit') }}
                                        </a>
                                    @endcan

                                    @can('ticket_delete')
                                        <form action="{{ route('admin.tickets.destroy', $ticket->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('ticket_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.tickets.massDestroy') }}",
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
  let table = $('.datatable-assigneTickets:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection