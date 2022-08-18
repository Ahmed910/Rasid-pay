<?php

namespace App\Http\Resources\Api\V1\Dashboard\Faq;

use App\Http\Resources\Api\V1\Dashboard\ActivityLogResource;
use App\Models\Faq\Faq;
use Illuminate\Http\Resources\Json\ResourceCollection;

class FaqCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $faq = Faq::with('translations')->findOrFail(@$request->route()->parameters['faq']);

        return [
            'faq'         => FaqResource::make($faq),
            'activity'    => ActivityLogResource::collection($this->collection)
        ];
    }
}
