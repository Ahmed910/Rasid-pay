<?php

namespace App\Http\Resources\Api\V1\Dashboard\StaticPages;

use App\Http\Resources\Api\V1\Dashboard\ActivityLogResource;
use App\Models\StaticPage\StaticPage;
use Illuminate\Http\Resources\Json\ResourceCollection;

class StaticPageCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $static_page = StaticPage::with('translations')->findOrFail(@$request->route()->parameters['static_page']);

        return [
            'static_page' => StaticPageResource::make($static_page),
            'activity'    => ActivityLogResource::collection($this->collection)
        ];
    }
}
