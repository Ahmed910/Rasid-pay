<?php

namespace App\Http\Resources\Api\Dashboard\Contact;

use App\Http\Resources\Api\Dashboard\ActivityLogResource;
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
        $contact = Contact::when(auth()->user()->user_type == 'admin', function ($q) {
            $q->where(function ($query) {
                $query->where('admin_id', auth()->user()->id)
                    ->orWhere('assigned_to_id', auth()->user()->id);
            });
        })->when($request['is_reply'], function ($q) {

            $q->where('message_status', "<>", Contact::REPLIED);
        })
            ->with('replies', 'user', 'admin', 'activity', 'assignedTo')
            ->withTrashed()
            ->findOrFail(@$request->route()->parameters['contact']);


        return [
            'contact'         => ContactResource::make($contact),
            'activity'    => ActivityLogResource::collection($this->collection)
        ];
    }
}
