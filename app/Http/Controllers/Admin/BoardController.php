<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyBoardRequest;
use App\Http\Requests\StoreBoardRequest;
use App\Http\Requests\UpdateBoardRequest;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BoardController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('board_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.boards.index');
    }

    public function create()
    {
        abort_if(Gate::denies('board_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.boards.create');
    }

    public function store(StoreBoardRequest $request)
    {
        $board = Board::create($request->all());

        return redirect()->route('admin.boards.index');
    }

    public function edit(Board $board)
    {
        abort_if(Gate::denies('board_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.boards.edit', compact('board'));
    }

    public function update(UpdateBoardRequest $request, Board $board)
    {
        $board->update($request->all());

        return redirect()->route('admin.boards.index');
    }

    public function show(Board $board)
    {
        abort_if(Gate::denies('board_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.boards.show', compact('board'));
    }

    public function destroy(Board $board)
    {
        abort_if(Gate::denies('board_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $board->delete();

        return back();
    }

    public function massDestroy(MassDestroyBoardRequest $request)
    {
        $boards = Board::find(request('ids'));

        foreach ($boards as $board) {
            $board->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
