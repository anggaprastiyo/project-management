<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Role;
use App\Models\User;
use Gate;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = User::with(['roles'])->select(sprintf('%s.*', (new User)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'user_show';
                $editGate      = 'user_edit';
                $deleteGate    = 'user_delete';
                $crudRoutePart = 'users';

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
            $table->editColumn('nik', function ($row) {
                return $row->nik ? $row->nik : '';
            });
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : '';
            });
            $table->editColumn('unit_name', function ($row) {
                return $row->unit_name ? $row->unit_name : '';
            });
            $table->editColumn('job_position_text', function ($row) {
                return $row->job_position_text ? $row->job_position_text : '';
            });
            $table->editColumn('email', function ($row) {
                return $row->email ? $row->email : '';
            });
            $table->editColumn('roles', function ($row) {
                $labels = [];
                foreach ($row->roles as $role) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $role->title);
                }

                return implode(' ', $labels);
            });

            $table->rawColumns(['actions', 'placeholder', 'roles']);

            return $table->make(true);
        }

        $roles = Role::get();

        return view('admin.users.index', compact('roles'));
    }

    public function create()
    {
        abort_if(Gate::denies('user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = Role::pluck('title', 'id');

        return view('admin.users.create', compact('roles'));
    }

    public function store(StoreUserRequest $request)
    {
        $user = User::create($request->all());
        $user->roles()->sync($request->input('roles', []));

        return redirect()->route('admin.users.index');
    }

    public function edit(User $user)
    {
        abort_if(Gate::denies('user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = Role::pluck('title', 'id');

        $user->load('roles');

        return view('admin.users.edit', compact('roles', 'user'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->all());
        $user->roles()->sync($request->input('roles', []));

        return redirect()->route('admin.users.index');
    }

    public function show(User $user)
    {
        abort_if(Gate::denies('user_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user->load('roles', 'projectOwnerProjects', 'assigneTickets');

        return view('admin.users.show', compact('user'));
    }

    public function destroy(User $user)
    {
        abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user->delete();

        return back();
    }

    public function massDestroy(MassDestroyUserRequest $request)
    {
        $users = User::find(request('ids'));

        foreach ($users as $user) {
            $user->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function syncUser(Request $request)
    {
        $this->validate($request, [
            'client_id' => 'required'
        ]);

        DB::beginTransaction();
        try {

            // call API
            $client = new Client();
            $response = $client->post(config('constant.sync_user.url'), [
                'auth' => [config('constant.sync_user.username'), config('constant.sync_user.password')],
                'json' => [
                    'CLIENT' => $request->input('client_id')
                ]
            ]);

            // Handle response
            if ($response->getStatusCode() == 200) {

                // parsing result
                $body = $response->getBody();
                $data = json_decode($body, true);
                $newUsers = $data['ZDATA']['item'];

                // get all current user
                $currentUsers = User::all();
                $insertUsers = collect();
                $updatedUser = 0;

                foreach ($newUsers as $newUser) {
                    if (isset($newUser['UNITCODE']) && isset($newUser['POSITIONNAME'])) {
                        $dataUser = collect()
                            ->put('nik', $newUser['NIK'])
                            ->put('name', $newUser['NAMA'])
                            ->put('unit_code', $newUser['UNITCODE'])
                            ->put('unit_name', $newUser['UNITNAME'])
                            ->put('job_position_code', $newUser['POSITIONCODE'])
                            ->put('job_position_text', $newUser['POSITIONNAME']);

                        $findUser = $currentUsers->where('nik', $newUser['NIK'])->first();
                        if (is_null($findUser)) {
                            $dataUser->put('uuid', Uuid::uuid4()->toString());
                            $insertUsers->push($dataUser);
                        } else {
                            if ($newUser['UNITCODE'] != $findUser->unit_code || $newUser['POSITIONCODE'] != $findUser->job_position_code) {
                                $findUser->update($dataUser->toArray());
                                $updatedUser++;
                            }
                        }
                    }
                }

                // mass insert users
                User::insert($insertUsers->toArray());

                DB::commit();

                return response()->json(['message' => 'success', 'insert' => $insertUsers->count(), 'update' => $updatedUser], Response::HTTP_OK);

            } else {
                return response()->json(['message' => 'Failed to Fetch API'], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json(['message' => $exception->getMessage()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

}
