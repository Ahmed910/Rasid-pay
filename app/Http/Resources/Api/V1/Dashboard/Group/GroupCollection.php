<?php

namespace App\Http\Resources\Api\V1\Dashboard\Group;

use App\Http\Resources\Api\V1\Dashboard\ActivityLogResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Models\Group\Group;

class GroupCollection extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // => function ($q) use($permissions) {
        //     $q->whereNotIn('permissions.id',$permissions);
        // }
        $group = Group::withCount('admins as user_count')->findOrFail(@$request->route()->parameters['group']);
        $permissions = $group->groups->pluck('permissions')->flatten()->pluck('id')->toArray();
        // dd($permissions);
        $group->load(['translations', 'groups' => function ($q) use($group){
            $q->with('permissions');
        }, 'permissions']);

        return [
            'group' => GroupResource::make($group),
            'activity' => ActivityLogResource::collection($this->collection),
        ];
    }
}
