@can($viewGate)
    <a class="btn btn-xs btn-primary" href="{{ route('admin.' . $crudRoutePart . '.show', $row->uuid) }}">
        <i class="fa fa-eye"></i>
    </a>
@endcan
@can($editGate)
    <a class="btn btn-xs btn-info" href="{{ route('admin.' . $crudRoutePart . '.edit', $row->uuid) }}">
        <i class="fa fa-edit"></i>
    </a>
@endcan
@can($deleteGate)
    <form id="delete-form-{{ $row->id }}" action="{{ route('admin.' . $crudRoutePart . '.destroy', $row->id) }}" method="POST" style="display: inline-block;">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <button type="button" class="btn btn-xs btn-danger" onclick="confirmDelete('{{ $row->id }}')"><i class="fa fa-trash"></i></button>
    </form>

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
@endcan