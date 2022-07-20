<?php

namespace App\Http\Resources\Dashboard\Contact;

use App\Http\Resources\Dashboard\ActivityLogResource;
use App\Models\Contact;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ContactCollection extends ResourceCollection
{
    public function toArray($request)
    {
        $contact = Contact::when(auth()->user()->user_type == 'admin', function ($q) {
            $q->where(function ($query) {
                $query->where('admin_id', auth()->id())
                    ->orWhere('assigned_to_id', auth()->id());
            });
        })
            ->with('replies', 'user', 'admin', 'activity')
            ->withTrashed()
            ->findOrFail($request->route()->parameters['contact']);


        return [
            'contact' => ContactResource::make($contact),
            'activity' => ActivityLogResource::collection($this->collection)
        ];
    }
}
