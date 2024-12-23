@extends('layouts.admin')
@section('content')
    @can('user_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.users.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.user.title_singular') }}
                </a>
                <a class="btn btn-default" onclick="syncUser()">
                    <i class="fa-fw nav-icon fas fa-sync"></i> Sync User
                </a>

            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.user.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-User">
                <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.user.fields.nik') }}
                    </th>
                    <th>
                        {{ trans('cruds.user.fields.name') }}
                    </th>
                    <th>
                        {{ trans('cruds.user.fields.unit_name') }}
                    </th>
                    <th>
                        {{ trans('cruds.user.fields.job_position_text') }}
                    </th>
                    <th>
                        {{ trans('cruds.user.fields.roles') }}
                    </th>
                    <th>
                        &nbsp;
                    </th>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
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
                        <select class="search">
                            <option value>{{ trans('global.all') }}</option>
                            @foreach($roles as $key => $item)
                                <option value="{{ $item->title }}">{{ $item->title }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                    </td>
                </tr>
                </thead>
            </table>
        </div>
    </div>

@endsection
@section('scripts')
    @parent
    <script>
        let table

        function syncUser() {

            Swal.fire({
                title: 'Are you sure?',
                text: "When synchronizing users, user data will be replaced with the latest data!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, synchronize it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    syncAction()
                }
            });
        }

        function syncAction() {
            Swal.fire({
                title: 'Processing',
                html: '<i class="fas fa-sync fa-spin"></i> Please Wait...',
                showConfirmButton: false,
                allowOutsideClick: false
            });
            $.ajax({
                headers: {'x-csrf-token': _token},
                method: 'POST',
                url: '{{ route('admin.users.sync') }}',
                data: {
                    client_id: 320
                },
                success: function (response) {
                    let message = '<b>New : ' + response.insert + ' User</b> | <b>Updated : ' + response.update + ' User</b>'
                    table.ajax.reload();
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        html: message,
                        confirmButtonColor: '#3085d6',
                    });
                },
                error: function (request, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Failed!',
                        text: request.responseText
                    });
                }
            })
        }

        $(function () {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            @can('user_delete')
            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
            let deleteButton = {
                text: deleteButtonTrans,
                url: "{{ route('admin.users.massDestroy') }}",
                className: 'btn-danger btn-xs',
                action: function (e, dt, node, config) {
                    var ids = $.map(dt.rows({selected: true}).data(), function (entry) {
                        return entry.id
                    });

                    if (ids.length === 0) {
                        alert('{{ trans('global.datatables.zero_selected') }}')
                        return
                    }

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
                            $.ajax({
                                headers: {'x-csrf-token': _token},
                                method: 'POST',
                                url: config.url,
                                data: {ids: ids, _method: 'DELETE'}
                            })
                                .done(function () {
                                    table.ajax.reload();
                                })
                        }
                    });
                }
            }
            dtButtons.push(deleteButton)
            @endcan

            let dtOverrideGlobals = {
                buttons: dtButtons,
                processing: true,
                serverSide: true,
                retrieve: true,
                aaSorting: [],
                ajax: "{{ route('admin.users.index') }}",
                columns: [
                    {data: 'placeholder', name: 'placeholder'},
                    {data: 'nik', name: 'nik'},
                    {data: 'name', name: 'name'},
                    {data: 'unit_name', name: 'unit_name'},
                    {data: 'job_position_text', name: 'job_position_text'},
                    {data: 'roles', name: 'roles.title'},
                    {data: 'actions', name: '{{ trans('global.actions') }}', width: '8%'}
                ],
                orderCellsTop: true,
                order: [[1, 'desc']],
                pageLength: 50,
            };

            table = $('.datatable-User').DataTable(dtOverrideGlobals);
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function (e) {
                $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
            });

            let visibleColumnsIndexes = null;
            $('.datatable thead').on('input', '.search', function () {
                let strict = $(this).attr('strict') || false
                let value = strict && this.value ? "^" + this.value + "$" : this.value

                let index = $(this).parent().index()
                if (visibleColumnsIndexes !== null) {
                    index = visibleColumnsIndexes[index]
                }

                table.column(index)
                    .search(value, strict)
                    .draw()
            });

            table.on('column-visibility.dt', function (e, settings, column, state) {
                visibleColumnsIndexes = []
                table.columns(":visible").every(function (colIdx) {
                    visibleColumnsIndexes.push(colIdx);
                });
            })
        });
    </script>
@endsection