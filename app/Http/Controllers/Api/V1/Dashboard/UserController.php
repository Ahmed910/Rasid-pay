<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Dashboard\UserRequest;
use App\Http\Resources\Dashboard\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
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
        $users = User::where('user_type', 'admin')->select('id', 'fullname', 'email', 'whatsapp', 'gender', 'is_active', 'created_at')->onlyTrashed()->latest()->paginate((int)($request->perPage ?? 10));
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


    public function store(UserRequest $request, User $user)
    {
        $user->fill($request->validated())->save();

        return UserResource::make($user)
            ->additional([
                'status' => true,
                'message' =>  trans('dashboard.general.success_add'),
            ]);
    }


    public function show($id)
    {
        $user = User::withTrashed()->findOrFail($id);
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


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }
}
