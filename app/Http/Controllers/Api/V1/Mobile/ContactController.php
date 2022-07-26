<?php

namespace App\Http\Controllers\Api\V1\Mobile;

use App\Http\Controllers\Controller;
use App\Models\{Contact, Setting, User};
use App\Http\Requests\V1\Mobile\ContactRequest;
use App\Http\Resources\Api\V1\Mobile\SettingResource;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $social_settings = ["rasid_social_fb_link", "rasid_social_linkedin_link", "rasid_social_instagram_link", "rasid_social_twitter_link", "rasid_social_whatsapp_link", "rasid_website_link"];
        $social = Setting::select('value->en as name', 'key')->whereIn('key', $social_settings)->get();
        return SettingResource::collection($social)->additional([
            'status' => true,
            'message' => ''
        ]);
    }


    public function store(ContactRequest $request , Contact $contact)
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
