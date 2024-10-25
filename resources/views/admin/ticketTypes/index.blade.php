@extends('layouts.admin')
@section('content')
@can('ticket_type_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.ticket-types.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.ticketType.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.ticketType.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-TicketType">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.ticketType.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.ticketType.fields.name') }}
                        </th>
                        <th>
                            {{ trans('cruds.ticketType.fields.color') }}
                        </th>
                        <th>
                            {{ trans('cruds.ticketType.fields.icon') }}
                        </th>
                        <th>
                            {{ trans('cruds.ticketType.fields.is_default') }}
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
                            <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                        </td>
                        <td>
                        </td>
                        <td>
                        </td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ticketTypes as $key => $ticketType)
                        <tr data-entry-id="{{ $ticketType->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $ticketType->id ?? '' }}
                            </td>
                            <td>
                                {{ $ticketType->name ?? '' }}
                            </td>
                            <td>
                                {{ $ticketType->color ?? '' }}
                            </td>
                            <td>
                                {{ $ticketType->icon ?? '' }}
                            </td>
                            <td>
                                <span style="display:none">{{ $ticketType->is_default ?? '' }}</span>
                                <input type="checkbox" disabled="disabled" {{ $ticketType->is_default ? 'checked' : '' }}>
                            </td>
                            <td>
                                @can('ticket_type_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.ticket-types.show', $ticketType->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('ticket_type_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.ticket-types.edit', $ticketType->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('ticket_type_delete')
                                    <form action="{{ route('admin.ticket-types.destroy', $ticketType->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('ticket_type_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.ticket-types.massDestroy') }}",
    className: 'btn-danger',
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
  let table = $('.datatable-TicketType:not(.ajaxTable)').DataTable({ buttons: dtButtons })
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