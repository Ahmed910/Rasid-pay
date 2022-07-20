<?php

namespace App\Http\Controllers\Api\V1\Mobile;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Http\Requests\V1\Mobile\ContactRequest;
use App\Models\User;
use Illuminate\Http\Request;

class ContactController extends Controller
{

    public function sendMessage(ContactRequest $request , Contact $contact)
    {
        $adminThatHaveMinMessages = User::where('user_type','admin')
        ->whereHas('permissions',fn($query) => $query->where('name','contacts.reply')->where('name','contacts.index'))
        ->whereRelation('messageTypes', 'message_types.id', $request->message_type_id)
        ->join('admins','admins.user_id','users.id')
        ->orderBy('admins.messages_count','asc')
        ->value('users.id');
        $contact->fill($request->validated()+['updated_at'=>now(),'admin_id' => $adminThatHaveMinMessages])->save();

        return response()->json([
            'status' => true,
            'message' =>  trans('dashboard.general.sent_successfully'),
            'data' => null
        ]);
    }
}
