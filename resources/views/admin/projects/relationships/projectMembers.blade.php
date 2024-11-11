<div class="m-3">
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.project.fields.member') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table
                    class=" table table-bordered table-striped table-sm">
                    <thead>
                    <tr>
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
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($members as $key => $member)
                        <tr data-entry-id="{{ $member->id }}">
                            <td>
                                {{ $member->nik ?? '' }}
                            </td>
                            <td>
                                {{ $member->name ?? '' }}
                            </td>
                            <td>
                                {{ $member->unit_name ?? '' }}
                            </td>
                            <td>
                                {{ $member->job_position_text ?? '' }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>