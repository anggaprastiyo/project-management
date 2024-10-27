@extends('layouts.admin')
@section('content')
@can('ticket_priority_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-primary" href="{{ route('admin.ticket-priorities.create') }}">
                <i class="fa-fw nav-icon fas fa-plus"></i> {{ trans('global.add') }} {{ trans('cruds.ticketPriority.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.ticketPriority.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-TicketPriority">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.ticketPriority.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.ticketPriority.fields.name') }}
                        </th>
                        <th>
                            {{ trans('cruds.ticketPriority.fields.color') }}
                        </th>
                        <th>
                            {{ trans('cruds.ticketPriority.fields.is_default') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                    <tr>
                        <td>
                        </td>
                        <td>
                            <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                        </td>
                        <td>
                            <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                        </td>
                        <td>
                            <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                        </td>
                        <td>
                        </td>
                        <td>
                        </td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ticketPriorities as $key => $ticketPriority)
                        <tr data-entry-id="{{ $ticketPriority->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $ticketPriority->id ?? '' }}
                            </td>
                            <td>
                                {{ $ticketPriority->name ?? '' }}
                            </td>
                            <td>
                                {{ $ticketPriority->color ?? '' }}
                            </td>
                            <td>
                                <span style="display:none">{{ $ticketPriority->is_default ?? '' }}</span>
                                <input type="checkbox" disabled="disabled" {{ $ticketPriority->is_default ? 'checked' : '' }}>
                            </td>
                            <td>
                                @can('ticket_priority_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.ticket-priorities.show', $ticketPriority->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('ticket_priority_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.ticket-priorities.edit', $ticketPriority->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('ticket_priority_delete')
                                    <form action="{{ route('admin.ticket-priorities.destroy', $ticketPriority->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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



@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('ticket_priority_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.ticket-priorities.massDestroy') }}",
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
  let table = $('.datatable-TicketPriority:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
let visibleColumnsIndexes = null;
$('.datatable thead').on('input', '.search', function () {
      let strict = $(this).attr('strict') || false
      let value = strict && this.value ? "^" + this.value + "$" : this.value

      let index = $(this).parent().index()
      if (visibleColumnsIndexes !== null) {
        index = visibleColumnsIndexes[index]
      }

      table
        .column(index)
        .search(value, strict)
        .draw()
  });
table.on('column-visibility.dt', function(e, settings, column, state) {
      visibleColumnsIndexes = []
      table.columns(":visible").every(function(colIdx) {
          visibleColumnsIndexes.push(colIdx);
      });
  })
})

</script>
@endsection