<?php

namespace App\Http\Controllers\BackCtrl;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;
use App\Http\Requests\UserRequest;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notifications = auth()->user()->unreadNotifications;

        return view('back-page.managament-users.index', [
            'title' => 'User',
            'notifications' => $notifications,
        ]);
    }

    /**
     * dataTable
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function dataTable(Request $request)
    {
        if ($request->ajax()) {
            $userRole = auth()->user()->roles->pluck("name")->first();

            $userRole == 'Admin'
                ? $users = $request->account_status == 'all'
                ? User::withCount('posts')->orderByDesc('id')->get()
                : User::withCount('posts')->where('is_active', $request->account_status)->orderByDesc('id')->get()
                : $users = User::withCount('posts')->find([auth()->user()->id]);

            return DataTables::of($users)
                ->addIndexColumn()
                ->addColumn('checkbox', function ($row) {
                    if ($row->id != auth()->user()->id && $row->posts_count <= 0) {
                        return "<input type='checkbox' name='user_checkbox' data-id='$row->id'>";
                    }
                })
                ->addColumn(
                    'roles',
                    fn ($row) => count($row->roles) > 0
                        ? $row->roles->map(
                            fn ($role) => "<span class='badge badge-default mr-1 my-1'>{$role['name']}</span>"
                        )->implode(' ')
                        : 'Tidak ada'
                )
                ->addColumn(
                    'account_status',
                    fn ($row) => $row->is_active
                        ? '<span class="badge badge-success">Aktif</span>'
                        : '<span class="badge badge-danger">Tidak Aktif</span>'
                )
                ->addColumn('action', function ($row) {
                    $userId = $row->id;

                    $actionBtn  = "<button type='button' name='edit' id='$userId' class='user-edit btn btn-sm fa fa-edit bg-warning mr-1 text-white'></button>";
                    if ($row->id != auth()->user()->id) {
                        $actionBtn .= "<button type='button' name=validate id='$userId' data-validate='$row->name' data-status='$row->is_active' class='user-validate btn btn-sm fa fa-times-circle bg-info mr-1 text-white'></button>";
                        $actionBtn .= "<button type='button' name='delete' id='$userId' data-delete='$row->name' class='user-delete btn btn-sm fa fa-trash-alt bg-danger text-white'></button>";
                    }

                    return $actionBtn;
                })
                ->rawColumns(['checkbox', 'roles', 'account_status', 'action'])
                ->make(true);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        if (request()->ajax()) {
            $roles = auth()->user()->roles->pluck("name")->first() === 'Admin'
                ? Role::get()
                : Role::where('name', '!=', 'Admin')->get();

            $user->setAttribute('role_selected', $user->roles->pluck('id')->toArray());

            return response()->json([
                'roles' => $roles,
                'user'  => $user
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $user)
    {
        if (request()->ajax()) {
            $user->update([
                'name'      => Str::title($request['name']),
                'username'  => preg_replace("/\s*/m", "", strtolower($request['name'])) ?? $user->username,
                'email'     => $request['email'],
            ]);

            $user->roles()->sync($request['role_ids']);

            return response()->json([
                'success' => "Berhasil mengubah data User $user->name"
            ]);
        }
    }

    /**
     * updateAccountStatus
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateAccountStatus(User $user)
    {
        if ($user->is_active) {
            $user->is_active = 0;
            $message['success'] = "User $user->name berhasil tidak divalidasi";
        } else {
            $user->is_active = 1;
            $message['success'] = "User $user->name berhasil divalidasi";
        }

        $user->save();

        return response()->json($message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if (request()->ajax()) {
            try {
                $user->roles()->detach();
                $user->delete();
            } catch (\Exception $ex) {
                $user->assignRole('Writer');
                return response()->json(
                    ['error' => "Error: User $user->name mempunyai Post"],
                    Response::HTTP_INTERNAL_SERVER_ERROR
                );
            }

            return response()->json([
                'success' => 'Berhasil menghapus kategori ' . $user->name
            ]);
        }
    }

    /**
     * destroyAllSelected
     *
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function destroyAllSelected(Request $request)
    {
        if ($request->ajax()) {
            $userIds = $request->user_ids;
            User::with(['roles'])->whereIn('id', $userIds)->get()
                ->map(function ($user) {
                    $user->roles()->detach();
                    $user->delete();
                });

            return response()->json([
                'success' => 'Berhasil menghapus semua User yang di pilih',
            ]);
        }
    }
}
