<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Dashboard\AdminRequest;
use App\Http\Resources\Dashboard\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    public function index(Request $request)
    {
        $users = User::where('user_type', 'admin')->select('id', 'fullname', 'email', 'whatsapp', 'gender', 'is_active', 'created_at')->latest()->paginate((int)($request->perPage ?? 10));

        return UserResource::collection($users)
            ->additional([
                'status' => true,
                'message' =>  '',
            ]);
    }

    public function archive(Request $request)
    {
        $users = User::onlyTrashed()->where('user_type', 'admin')->select('id', 'fullname', 'email', 'whatsapp', 'gender', 'is_active', 'created_at')->latest()->paginate((int)($request->perPage ?? 10));
        return UserResource::collection($users)
            ->additional([
                'status' => true,
                'message' =>  ''
            ]);
    }

    public function create()
    {
        //
    }


    public function store(AdminRequest $request, User $user)
    {
        $user->fill($request->validated() + ['added_by_id' => auth()->id()])->save();

        return UserResource::make($user)
            ->additional([
                'status' => true,
                'message' =>  trans('dashboard.general.success_add'),
            ]);
    }


    public function show($id)
    {
        $user = User::withTrashed()->with(['addedBy', 'country', 'role'])->findOrFail($id);

        return UserResource::make($user)
            ->additional([
                'status' => true,
                'message' =>  '',
            ]);
    }


    public function edit($id)
    {
        //
    }


    public function update(AdminRequest $request, User $admin)
    {
        $admin->fill($request->validated())->save();

        return UserResource::make($admin)
            ->additional([
                'status' => true,
                'message' =>  trans('dashboard.general.success_update'),
            ]);
    }

    //archive data
    public function destroy(User $admin)
    {
        $admin->delete();
        return UserResource::make($admin)
            ->additional([
                'status' => true,
                'message' =>  trans('dashboard.general.success_archive'),
            ]);
    }

    //restore data from archive
    public function restore($id)
    {
        $admin = User::onlyTrashed()->findOrFail($id);
        $admin->restore();

        return UserResource::make($admin)
            ->additional([
                'status' => true,
                'message' =>  trans('dashboard.general.success_restore'),
            ]);
    }

    //force delete data from archive
    public function forceDelete($id)
    {
        $admin = User::onlyTrashed()->findOrFail($id);
        $admin->forceDelete();

        return UserResource::make($admin)
            ->additional([
                'status' => true,
                'message' =>  trans('dashboard.general.success_delete'),
            ]);
    }
}
