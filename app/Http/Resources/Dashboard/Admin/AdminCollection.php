<?php

namespace App\Http\Resources\Dashboard\Admin;

use App\Http\Resources\Dashboard\{ActivityLogResource, UserResource};
use Illuminate\Http\Resources\Json\ResourceCollection;

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
        return [
            'user' => UserResource::make($this->collection['admin']),
            'activity' => ActivityLogResource::collection($this->collection->except('admin'))
        ];
    }
}
