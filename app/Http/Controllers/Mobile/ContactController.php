<?php

namespace App\Http\Controllers\Api\V1\Mobile;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Http\Requests\V1\Mobile\ContactRequest;

class ContactController extends Controller
{

    public function sendMessage(ContactRequest $request, Contact $contact)
    {
        $contact->fill($request->validated()+['updated_at'=>now()])->save();

        return response()->json([
            'status' => true,
            'message' =>  trans('dashboard.general.sent_successfully'),
            'data' => null
        ]);
    }
}
