<?php

namespace App\Http\Resources\Dashboard\Admin;

use App\Http\Resources\Dashboard\{ActivityLogResource, UserResource};
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Models\User;

class AdminCollection extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $admin = User::withTrashed()->where('user_type', 'admin')->with(['addedBy', 'country', 'groups' => function ($q) {
            $q->with('permissions');
        }])->findOrFail(@$request->route()->parameters['admin']);

        $admin->load('permissions');

        return [
            'user' => UserResource::make($admin),
            'activity' => ActivityLogResource::collection($this->collection)
        ];
    }
}
