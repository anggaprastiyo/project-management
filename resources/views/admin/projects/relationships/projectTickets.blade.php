<div class="m-3">
    @can('ticket_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-info" href="{{ route('admin.tickets.create', ['project_id' => $project->uuid]) }}">
                    <i class="fa fa-plus"></i> {{ trans('global.add') }} {{ trans('cruds.ticket.title_singular') }}
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
                <table class=" table table-bordered table-striped table-hover datatable datatable-projectTickets">
                    <thead>
                    <tr>
                        <th width="10">

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
                                {{ $ticket->code ?? '' }}
                            </td>
                            <td>
                                {{ $ticket->name ?? '' }}
                            </td>
                            <td>
                                {{ $ticket->assigne->name ?? '' }}
                            </td>
                            <td>
                                <span class="color-circle" style="background-color:{{  $ticket->status->color }}"></span>
                                {{ $ticket->status->name ?? '' }}
                            </td>
                            <td>
                                <span class="color-circle" style="background-color:{{  $ticket->type->color }}"></span>
                                {{ $ticket->type->name ?? '' }}
                            </td>
                            <td>
                                <span class="color-circle" style="background-color:{{  $ticket->priority->color }}"></span>
                                {{ $ticket->priority->name ?? '' }}
                            </td>
                            <td>
                                @can('ticket_show')
                                    <a class="btn btn-xs btn-primary"
                                       href="{{ route('admin.tickets.show', $ticket->uuid) }}">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                @endcan

                                @can('ticket_edit')
                                    <a class="btn btn-xs btn-info"
                                       href="{{ route('admin.tickets.edit', $ticket->uuid) }}">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                @endcan

                                @can('ticket_delete')
                                    <form action="{{ route('admin.tickets.destroy', $ticket->uuid) }}" method="POST"
                                          onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
                                          style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <button type="button" class="btn btn-xs btn-danger" onclick="confirmDelete('{{ $ticket->id }}')"><i class="fa fa-trash"></i></button>
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
                    var ids = $.map(dt.rows({selected: true}).nodes(), function (entry) {
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
                            data: {ids: ids, _method: 'DELETE'}
                        })
                            .done(function () {
                                location.reload()
                            })
                    }
                }
            }
            dtButtons.push(deleteButton)
            @endcan

            $.extend(true, $.fn.dataTable.defaults, {
                orderCellsTop: true,
                order: [[1, 'desc']],
                pageLength: 100,
            });
            let table = $('.datatable-projectTickets:not(.ajaxTable)').DataTable({buttons: dtButtons})
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function (e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

        })

    </script>

    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit the form
                    $('#delete-form-' + id).submit();
                }
            });
        }
    </script>
@endsection