<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Http\Requests\V1\dashboard\ContactAdminAssignRequest;
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
        $contact = Contact::when(auth()->user()->user_type == 'admin', function ($q) {
            $q->whereHas('messageType.admins',function($query){
                $query->where('admin_id',auth()->user()->id);
            });
        })
            ->with('replies', 'user')
            ->CustomDateFromTo($request)
            ->search($request)
            ->sortby($request)
            ->paginate((int)($request->per_page ?? config("globals.per_page")));
        return ContactResource::collection($contact)
            ->additional([
                'status' => true,
                'message' => ''
            ]);
    }


    public function reply(ContactReplyRequest $request, ContactReply $contactReply)
    {
        $contactReply->fill($request->validated()+['added_by_id' => auth()->id()]+['updated_at'=>now()])->save();
        $contactReply->contact->update(["message_status" => "replied"]);
        // TODO: Send to user email
        return ContactReplyResource::make($contactReply->load('contact'))
            ->additional([
                'status' => true,
                'message' =>  trans('dashboard.general.success_add')
            ]);
    }

    public function show($id)
    {
        $contact = Contact::when(auth()->user()->user_type == 'admin', function ($q) {
            $q->whereHas('messageType.admins',function($query){
                $query->where('admin_id',auth()->user()->id);
            });
        })
        ->with('replies', 'user','admin')
        ->withTrashed()
        ->findOrFail($id);
        $contact->update(['read_at' => now(),"message_status"=>$contact->message_status=="new"?"pending":$contact->message_status]);

        return ContactResource::make($contact)
            ->additional([
                'status' => true,
                'message' => ''
            ]);
    }
    public function assignContact(ContactAdminAssignRequest $contactAdminAssignRequest , Contact $contact){

      $contact->update($contactAdminAssignRequest->validated()) ;
        return ContactResource::make($contact)
            ->additional([
                'status' => true,
                'message' =>  trans('dashboard.general.success_update')
            ]);

    }

    public function deleteContact($id)
    {
        $contact = Contact::when(auth()->user()->user_type == 'admin', function ($q) {
            $q->whereHas('messageType.admins',function($query){
                $query->where('admin_id',auth()->user()->id);
            });
        })
        ->findorfail($id);
        $contact->delete();

        return response()->json([
            'status' => true,
            'message' =>  trans('dashboard.general.success_archive'),
            'data' => null
        ]);
    }

    public function deleteReply($id)
    {
        $contact = ContactReply::when(auth()->user()->user_type == 'admin', function ($q) {
            $q->whereHas('contact.messageType.admins',function($query){
                $query->where('admin_id',auth()->user()->id);
            });
        })
        ->findorfail($id);
        $contact->delete();

        return response()->json([
            'status' => true,
            'message' =>  trans('dashboard.general.success_archive'),
            'data' => null
        ]);
    }
}
