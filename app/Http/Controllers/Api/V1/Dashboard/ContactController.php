<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Models\Contact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Dashboard\ContactResource;
use App\Http\Resources\Dashboard\ContactReplyResource;
use App\Http\Requests\V1\Dashboard\ContactReplyRequest;
use App\Models\ContactReply;

class ContactController extends Controller
{

    public function index(Request $request)
    {
        $contact = Contact::with('replies', 'user')->latest()->paginate((int)($request->page ?? 15));

        return ContactResource::collection($contact)
            ->additional([
                'status' => true,
                'message' => ''
            ]);
    }


    public function reply(ContactReplyRequest $request, ContactReply $contactReply)
    {
        $contactReply->fill($request->validated())->save();

        return ContactReplyResource::make($contactReply->load('contact'))
            ->additional([
                'status' => true,
                'message' =>  trans('dashboard.general.success_add')
            ]);
    }

    public function show($id)
    {
        $contact = Contact::with('replies', 'user')->withTrashed()->findOrFail($id);
        $contact->update(['read_at' => now()]);

        return ContactResource::make($contact)
            ->additional([
                'status' => true,
                'message' => ''
            ]);
    }

    public function deleteContact($id)
    {
        $contact = Contact::findorfail($id);
        $contact->delete();

        return response()->json([
            'status' => true,
            'message' =>  trans('dashboard.general.success_archive'),
            'data' => null
        ]);
    }

    public function deleteReply($id)
    {
        $contact = ContactReply::findorfail($id);
        $contact->delete();

        return response()->json([
            'status' => true,
            'message' =>  trans('dashboard.general.success_archive'),
            'data' => null
        ]);
    }
}
