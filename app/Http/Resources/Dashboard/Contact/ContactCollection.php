<?php

namespace App\Http\Resources\Dashboard\Contact;

use App\Http\Resources\Dashboard\ActivityLogResource;
use App\Models\Contact;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ContactCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $contact = Contact::findOrFail(@$request->route()->parameters['contact']);

        return [
            'contact'         => ContactResource::make($contact),
            'activity'    => ActivityLogResource::collection($this->collection)
        ];
    }
}
