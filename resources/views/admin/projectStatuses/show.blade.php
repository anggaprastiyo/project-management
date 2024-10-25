@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.projectStatus.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.project-statuses.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.projectStatus.fields.id') }}
                        </th>
                        <td>
                            {{ $projectStatus->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.projectStatus.fields.name') }}
                        </th>
                        <td>
                            {{ $projectStatus->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.projectStatus.fields.color') }}
                        </th>
                        <td>
                            {{ $projectStatus->color }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.projectStatus.fields.is_default') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $projectStatus->is_default ? 'checked' : '' }}>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.project-statuses.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        {{ trans('global.relatedData') }}
    </div>
    <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
        <li class="nav-item">
            <a class="nav-link" href="#project_status_projects" role="tab" data-toggle="tab">
                {{ trans('cruds.project.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="project_status_projects">
            @includeIf('admin.projectStatuses.relationships.projectStatusProjects', ['projects' => $projectStatus->projectStatusProjects])
        </div>
    </div>
</div>

@endsection