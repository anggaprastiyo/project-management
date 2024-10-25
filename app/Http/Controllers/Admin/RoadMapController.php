<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyRoadMapRequest;
use App\Http\Requests\StoreRoadMapRequest;
use App\Http\Requests\UpdateRoadMapRequest;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoadMapController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('road_map_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.roadMaps.index');
    }

    public function create()
    {
        abort_if(Gate::denies('road_map_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.roadMaps.create');
    }

    public function store(StoreRoadMapRequest $request)
    {
        $roadMap = RoadMap::create($request->all());

        return redirect()->route('admin.road-maps.index');
    }

    public function edit(RoadMap $roadMap)
    {
        abort_if(Gate::denies('road_map_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.roadMaps.edit', compact('roadMap'));
    }

    public function update(UpdateRoadMapRequest $request, RoadMap $roadMap)
    {
        $roadMap->update($request->all());

        return redirect()->route('admin.road-maps.index');
    }

    public function show(RoadMap $roadMap)
    {
        abort_if(Gate::denies('road_map_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.roadMaps.show', compact('roadMap'));
    }

    public function destroy(RoadMap $roadMap)
    {
        abort_if(Gate::denies('road_map_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roadMap->delete();

        return back();
    }

    public function massDestroy(MassDestroyRoadMapRequest $request)
    {
        $roadMaps = RoadMap::find(request('ids'));

        foreach ($roadMaps as $roadMap) {
            $roadMap->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
