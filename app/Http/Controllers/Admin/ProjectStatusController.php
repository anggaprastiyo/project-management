<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyProjectStatusRequest;
use App\Http\Requests\StoreProjectStatusRequest;
use App\Http\Requests\UpdateProjectStatusRequest;
use App\Models\ProjectStatus;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class ProjectStatusController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('project_status_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = ProjectStatus::query()->select(sprintf('%s.*', (new ProjectStatus)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'project_status_show';
                $editGate      = 'project_status_edit';
                $deleteGate    = 'project_status_delete';
                $crudRoutePart = 'project-statuses';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : '';
            });
            $table->editColumn('color', function ($row) {
                return $row->color ? $row->color : '';
            });
            $table->editColumn('is_default', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->is_default ? 'checked' : null) . '>';
            });

            $table->rawColumns(['actions', 'placeholder', 'is_default']);

            return $table->make(true);
        }

        return view('admin.projectStatuses.index');
    }

    public function create()
    {
        abort_if(Gate::denies('project_status_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.projectStatuses.create');
    }

    public function store(StoreProjectStatusRequest $request)
    {
        $projectStatus = ProjectStatus::create($request->all());

        return redirect()->route('admin.project-statuses.index');
    }

    public function edit(ProjectStatus $projectStatus)
    {
        abort_if(Gate::denies('project_status_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.projectStatuses.edit', compact('projectStatus'));
    }

    public function update(UpdateProjectStatusRequest $request, ProjectStatus $projectStatus)
    {
        $projectStatus->update($request->all());

        return redirect()->route('admin.project-statuses.index');
    }

    public function show(ProjectStatus $projectStatus)
    {
        abort_if(Gate::denies('project_status_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $projectStatus->load('projectStatusProjects');

        return view('admin.projectStatuses.show', compact('projectStatus'));
    }

    public function destroy(ProjectStatus $projectStatus)
    {
        abort_if(Gate::denies('project_status_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $projectStatus->delete();

        return back();
    }

    public function massDestroy(MassDestroyProjectStatusRequest $request)
    {
        $projectStatuses = ProjectStatus::find(request('ids'));

        foreach ($projectStatuses as $projectStatus) {
            $projectStatus->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
