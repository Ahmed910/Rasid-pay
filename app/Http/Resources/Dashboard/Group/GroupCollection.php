<?php

namespace App\Http\Resources\Dashboard\Group;

use App\Http\Resources\Dashboard\ActivityLogResource;
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
        $group = Group::findOrFail(@$request->route()->parameters['group']);
        $group->load(['translations', 'groups' => function ($q) {
            $q->with('permissions');
        }, 'permissions']);

        return [
            'group' => GroupResource::make($group),
            'activity' => ActivityLogResource::collection($this->collection),
        ];
    }
}
