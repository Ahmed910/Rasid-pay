<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Mobile\MessageTypeResource;
use App\Models\MessageType\MessageType;

class MessageTypeController extends Controller
{
    public function index()
    {
        $messageTypes = MessageType::where("is_active",true)->ListsTranslations('name')->latest()->get();
        return MessageTypeResource::collection($messageTypes)
            ->additional([
                'status' => true,
                'message' => "",
            ]);
    }
}
