<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Exports\TransferPurposeExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\TransferPurposeRequest;
use App\Http\Resources\Api\Dashboard\TransferPurpose\TransferPurposeCollection;
use App\Http\Resources\Api\Dashboard\TransferPurpose\TransferPurposeResource;
use App\Models\ActivityLog;
use App\Models\TransferPurpose\TransferPurpose;
use Illuminate\Http\Request;
use App\Services\GeneratePdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Traits\Loggable;
class TransferPurposeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $transfer_purposes = TransferPurpose::search($request)
            ->sortBy($request)->paginate((int)($request->per_page ?? config("globals.per_page")));
        return TransferPurposeResource::collection($transfer_purposes)->additional([
            'message' => '',
            'status' => true
        ]);
    }


    public function store(TransferPurposeRequest $request)
    {
        $transfer_purpose = TransferPurpose::create($request->validated());
        return TransferPurposeResource::make($transfer_purpose)->additional([
            'message' => trans('dashboard.general.success_add'),
            'status' => true
        ]);
    }

    public function show(Request $request, $id)
    {
        $transferPurpose  = TransferPurpose::findOrFail($id);
        $activities = [];
        if ((!$request->has('with_activity') || $request->with_activity) && $request->routeIs('*.show')) {
            $activities  = $transferPurpose->activity()
                ->sortBy($request)
                ->paginate((int)($request->per_page ??  config("globals.per_page")));
        }

        return TransferPurposeCollection::make($activities)
            ->additional([
                'status' => true,
                'message' => trans("dashboard.general.show")
            ]);
    }




    public function update(TransferPurposeRequest $request, TransferPurpose $transfer_purpose)
    {
        if($transfer_purpose->is_another){
            return response()->json([
                'data'    => null,
                'message' => trans('dashboard.general.cannot_update'),
                'status'  => true
            ]);
        }

        $transfer_purpose->update($request->validated());
        return TransferPurposeResource::make($transfer_purpose)->additional([
            'message' => trans('dashboard.general.success_update'),
            'status' => true
        ]);
    }


    public function destroy(TransferPurpose $transfer_purpose)
    {
        $transfer_purpose->delete();
        return TransferPurposeResource::make($transfer_purpose)
            ->additional([
                'status' => true,
                'message' => trans("dashboard.general.success_delete")
            ]);
    }


    public function exportPDF(Request $request, GeneratePdf $generatePdf)
    {
        $TransferPurposesQuery = TransferPurpose::search($request)
        ->sortBy($request)
        ->get();
        Loggable::addGlobalActivity(TransferPurpose::class, $request->query(), ActivityLog::EXPORT, 'index');

        if (!$request->has('created_from')) {
            $createdFrom = TransferPurpose::selectRaw('MIN(created_at) as min_created_at')->value('min_created_at');
        }

        $chunk = 200;
        $names = [];
        foreach (($TransferPurposesQuery->chunk($chunk)) as $key => $rows) {
            $names[] = base_path('storage/app/public/') . $generatePdf->newFile()
                    ->setHeader(trans('dashboard.transfer_purpose.transfer_purposes'),  $createdFrom)
                    ->view('dashboard.exports.transfer_purpose', $rows, $key, $chunk)
                    ->storeOnLocal('transfer_purposes/pdfs/');
        }

        $file = GeneratePdf::mergePdfFiles($names, 'transfer_purposes/pdfs/transfer_purposes.pdf');

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
        Excel::store(new TransferPurposeExport($request), 'TransferPurposes/excels/' . $fileName . '.xlsx', 'public');
        $file = url('/storage/' . 'TransferPurposes/excels/' . $fileName . '.xlsx');
        Loggable::addGlobalActivity(TransferPurpose::class, $request->query(), ActivityLog::EXPORT, 'index');

        return response()->json([
            'data'   => [
                'file' => $file
            ],
            'status' => true,
            'message' => ''
        ]);
    }
}
