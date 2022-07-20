<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Dashboard\ContactAdminAssignRequest;
use App\Http\Requests\V1\Dashboard\ContactReplyRequest;
use App\Http\Resources\Dashboard\Contact\ContactCollection;
use App\Http\Resources\Dashboard\ContactReplyResource;
use App\Http\Resources\Dashboard\Contact\ContactResource;
use App\Models\Contact;
use App\Models\ContactReply;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        $contacts = Contact::when(auth()->user()->user_type == 'admin', function ($q) {
            $q->where(function($query)
            {
                $query->where('admin_id', auth()->user()->id)
                    ->orWhere('assigned_to_id', auth()->user()->id);
            });
        })
            ->with('replies', 'user', 'admin', 'activity')
            ->CustomDateFromTo($request)
            ->search($request)
            ->sortby($request)
            ->paginate((int)($request->per_page ?? config("globals.per_page")));
        return ContactResource::collection($contacts)
            ->additional([
                'status' => true,
                'message' => ''
            ]);
    }


    public function reply(ContactReplyRequest $request, ContactReply $contactReply)
    {

       $contact = Contact::findorfail($request['contact_id']);

        if($contact->replies()->exists()){
            return response()->json([
                'status' => true,
                'message' => trans('dashboard.contact.replied'),
                'data' => null
            ]);
        }

        $contactReply->fill($request->validated() + ['added_by_id' => auth()->id()] + ['updated_at' => now()])->save();
        $contactReply->contact->update(["message_status" => Contact::REPLIED]);
        // TODO: Send to user email
        return ContactReplyResource::make($contactReply->load('contact', 'admin'))
            ->additional([
                'status' => true,
                'message' => trans('dashboard.general.success_add')
            ]);

    }

    public function show(Request $request,$id)
    {
        $contact = Contact::when(auth()->user()->user_type == 'admin', function ($q) {
            $q->where(function ($query) {
                $query->where('admin_id', auth()->user()->id)
                    ->orWhere('assigned_to_id', auth()->user()->id);
            });
        })
            ->with('replies', 'user', 'admin', 'activity')
            ->withTrashed()
            ->findOrFail($id);

        $contact->update([
            'read_at' => now(),
            "message_status" => $contact->message_status == Contact::PENDING ? Contact::SHOWN : $contact->message_status
        ]);
        $activities = [];
        if (!$request->has('with_activity') || $request->with_activity) {
            $activities  = $contact->activity()
                ->sortBy($request)
                ->paginate((int)($request->per_page ??  config("globals.per_page")));
        }

        return ContactCollection::make($activities)
        ->additional([
            'status' => true,
            'message' => trans("dashboard.general.show")
        ]);


    }

    public function assignContact(ContactAdminAssignRequest $request, Contact $contact)
    {
        $contact->update($request->validated());
        return ContactResource::make($contact->load("admin"))
            ->additional([
                'status' => true,
                'message' => trans('dashboard.general.success_update')
            ]);
    }

    public function deleteContact($id)
    {
        $contact = Contact::when(auth()->user()->user_type == 'admin', function ($q) {
            $q->whereHas('messageType.admins', function ($query) {
                $query->where('admin_id', auth()->user()->id);
            });
        })->findorfail($id);
        $contact->delete();
        return response()->json([
            'status' => true,
            'message' => trans('dashboard.general.success_archive'),
            'data' => null
        ]);
    }

    public function deleteReply($id)
    {
        $contact = ContactReply::when(auth()->user()->user_type == 'admin', function ($q) {
            $q->whereHas('contact.messageType.admins', function ($query) {
                $query->where('admin_id', auth()->user()->id);
            });
        })
            ->findorfail($id);
        $contact->delete();
        return response()->json([
            'status' => true,
            'message' => trans('dashboard.general.success_archive'),
            'data' => null
        ]);
    }
}
