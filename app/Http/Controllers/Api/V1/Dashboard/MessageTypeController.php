<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Resources\Dashboard\MessageTypeResource;
use App\Models\MessageType\MessageType;
use Illuminate\Http\Request;

class MessageTypeController extends Controller
{
    public function index(Request $request)
    {
        $messageTypes = MessageType::ListsTranslations('name')
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

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        $messageType = MessageType::withCount('admins')->with('admins')->findOrFail($id);
        return MessageTypeResource::make($messageType)
            ->additional([
                'status' => true,
                'message' => "",
            ]);
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        $messageType = MessageType::findOrFail($id);
        $messageType->delete();
        return MessageTypeResource::make($messageType)
            ->additional([
                'status' => true,
                'message' => trans("dashboard.general.success_delete")
            ]);

    }
}
