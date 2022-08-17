<?php

namespace App\Http\Resources\Api\V1\Dashboard\Citizen;

use App\Models\Citizen;
use App\Http\Resources\Api\V1\Dashboard\ActivityLogResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\Api\V1\Dashboard\Citizen\CitizenResource;

class CitizenCollection extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $citizen = Citizen::where('user_id', @$request->route()->parameters['citizen'])->with("user", "enabledPackage")->firstOrFail();

        return [
            'citizen' => CitizenResource::make($citizen),
            'activity' => ActivityLogResource::collection($this->collection)
        ];
    }
}
