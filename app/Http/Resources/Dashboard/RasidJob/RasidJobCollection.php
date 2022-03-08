<?php

namespace App\Http\Resources\Dashboard\RasidJob;

use App\Http\Resources\Dashboard\ActivityLogResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class RasidJobCollection extends ResourceCollection
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
            'job' => RasidJobResource::make($this->collection['job']),
            'activity' => ActivityLogResource::collection($this->collection->except('job'))
        ];
    }
}
