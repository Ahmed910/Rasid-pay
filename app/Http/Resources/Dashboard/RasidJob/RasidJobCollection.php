<?php

namespace App\Http\Resources\Dashboard\RasidJob;

use App\Http\Resources\Dashboard\ActivityLogResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Models\RasidJob\RasidJob;

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
        $rasidJob  = RasidJob::withTrashed()->with('translations', 'employee')->findOrFail($request->route()->parameters['rasid_job']);
        return [
            'job' => RasidJobResource::make($rasidJob),
            'activity' => ActivityLogResource::collection($this->collection)
        ];
    }
}
