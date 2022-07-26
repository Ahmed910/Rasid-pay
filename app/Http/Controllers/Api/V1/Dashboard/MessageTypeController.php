<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Dashboard\MessageTypeRequest;
use App\Http\Resources\Dashboard\MessageTypeResource;
use App\Http\Resources\Dashboard\MessageTypeCollection;
use App\Models\MessageType\MessageType;
use Illuminate\Http\Request;

class MessageTypeController extends Controller
{
    public function index(Request $request)
    {
        $messageTypes = MessageType::ListsTranslations('name')
            ->addSelect('created_at', 'is_active')
            ->withCount('admins')
            ->search($request)
            ->CustomDateFromTo($request)
            ->sortBy($request)
            ->paginate((int)($request->per_page ?? config("globals.per_page")));

        return MessageTypeResource::collection($messageTypes)
            ->additional([
                'status' => true,
                'message' => "",
            ]);
    }

    public function store(MessageTypeRequest $request, MessageType $messageType)
    {
        $data = $request->validated();
        $messageType->fill($data)->save();
        $messageType->admins()->sync($data['admins']);

        return MessageTypeResource::make($messageType)
            ->additional([
                'status' => true,
                'message' => trans("dashboard.general.success_add")
            ]);
    }

    public function show($id, Request $request)
    {
        $messageType = MessageType::withCount('admins')->with('admins', 'activity')->findOrFail($id);
        $activities = [];
        $activities = $messageType->activity()
            ->sortBy($request)
            ->paginate((int)($request->per_page ?? config("globals.per_page")));

        return MessageTypeCollection::make($activities)
            ->additional([
                'status' => true,
                'message' => "",
            ]);
    }

    public function update(MessageTypeRequest $request, MessageType $messageType)
    {
        $data = $request->validated();
        $messageType->fill($data + ['updated_at' => now()])->save();
        $messageType->admins()->sync($data['admins']);

        return MessageTypeResource::make($messageType)
            ->additional([
                'status' => true,
                'message' => trans("dashboard.general.success_update")
            ]);
    }

    public function destroy($id)
    {
        $messageType = MessageType::findOrFail($id);
        if (!$messageType->contact()->exists()) {
            $messageType->delete();
            return MessageTypeResource::make($messageType)
                ->additional([
                    'status' => true,
                    'message' => trans("dashboard.general.success_delete")
                ]);
        }
        return response()->json([
            'data' => "",
            'status' => true,
            'message' => trans("dashboard.contact.can_not_delete_contact"),
        ]);
    }


    public function getAllMessageTypes(Request $request)
    {
        return response()->json([
            'data' => MessageType::select('id')
                ->ListsTranslations('name')
                ->get(),
            'status' => true,
            'message' => '',
        ]);
    }
}
