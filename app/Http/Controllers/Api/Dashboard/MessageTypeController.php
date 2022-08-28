<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Exports\MessageTypeExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\MessageTypeRequest;
use App\Http\Resources\Api\Dashboard\MessageTypeResource;
use App\Http\Resources\Api\Dashboard\MessageTypeCollection;
use App\Models\ActivityLog;
use App\Models\MessageType\MessageType;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\GeneratePdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Traits\Loggable;
class MessageTypeController extends Controller
{
    public function index(Request $request)
    {
        $messageTypes = MessageType::ListsTranslations('name')
            ->addSelect('created_at', 'is_active')
            ->withCount('admins')
            ->search($request)
            ->customDateFromTo($request)
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
        if((!$request->has('with_activity') || $request->with_activity) && $request->routeIs('*.show')) {
            $activities = $messageType->activity()
                ->sortBy($request)
                ->paginate((int)($request->per_page ?? config("globals.per_page")));
        }

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
    public function exportPDF(Request $request, GeneratePdf $generatePdf)
    {
        $messageTypesQuery = MessageType::ListsTranslations('name')
        ->addSelect('created_at', 'is_active')
        ->withCount('admins')
        ->search($request)
        ->customDateFromTo($request)
        ->sortBy($request)
        ->get();

        Loggable::addGlobalActivity(MessageType::class, array_merge(
            $request->query(),
            ['employee_list' => User::find($request->employee_list)?->pluck('fullname')]
        ), ActivityLog::SEARCH, 'index');


        if (!$request->has('created_from')) {
            $createdFrom = MessageType::selectRaw('MIN(created_at) as min_created_at')->value('min_created_at');
        }


        $chunk = 200;
        $names = [];
        if (!$messageTypesQuery->count()) {
            $file = GeneratePdf::createNewFile(
                trans('dashboard.message_type.message_types'),
                $createdFrom,'dashboard.exports.message_type',
                $messageTypesQuery,0,$chunk,'message_types/pdfs/'
            );
            $file =  url(str_replace(base_path('storage/app/public/'), 'storage/', $file));
            return response()->json([
                'data'   => [
                    'file' => $file
                ],
                'status' => true,
                'message' => ''
            ]);
        }
        foreach (($messageTypesQuery->chunk($chunk)) as $key => $rows) {
            $names[] = GeneratePdf::createNewFile(
                trans('dashboard.message_type.message_types'),$createdFrom,
                'dashboard.exports.message_type',
                $rows,$key,$chunk,'message_types/pdfs/'
            );
        }

        $file = GeneratePdf::mergePdfFiles($names, 'message_types/pdfs/message_types.pdf');

        return response()->json([
            'data'   => [
                'file' => $file
            ],
            'status' => true,
            'message' => ''
        ]);
    }

    public function exportExcel(Request $request)
    {
        $fileName = uniqid() . time();
        Excel::store(new MessageTypeExport($request), 'MessageTypes/excels/' . $fileName . '.xlsx', 'public');
        $file = url('/storage/' . 'MessageTypes/excels/' . $fileName . '.xlsx');
        Loggable::addGlobalActivity(MessageType::class, array_merge(
            $request->query(),
            ['employee_list' => User::find($request->employee_list)?->pluck('fullname')]
        ), ActivityLog::SEARCH, 'index');

        return response()->json([
            'data'   => [
                'file' => $file
            ],
            'status' => true,
            'message' => ''
        ]);
    }
}
