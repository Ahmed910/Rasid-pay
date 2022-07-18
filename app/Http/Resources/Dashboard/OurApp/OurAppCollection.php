<?php

namespace App\Http\Resources\Dashboard\OurApp;

use App\Http\Resources\Dashboard\ActivityLogResource;
use App\Models\OurApp\OurApp;
use Illuminate\Http\Resources\Json\ResourceCollection;

class OurAppCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $ourApp = OurApp::with('translations')->findOrFail(@$request->route()->parameters['our_app']);

        return [
            'app'         => OurAppResource::make($ourApp),
            'activity'    => ActivityLogResource::collection($this->collection)
        ];
    }
}
