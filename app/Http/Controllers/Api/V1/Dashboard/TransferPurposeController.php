<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Exports\TransferPurposeExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Dashboard\TransferPurposeRequest;
use App\Http\Resources\Dashboard\TransferPurpose\TransferPurposeCollection;
use App\Http\Resources\Dashboard\TransferPurpose\TransferPurposeResource;
use App\Models\TransferPurpose\TransferPurpose;
use Illuminate\Http\Request;
use App\Services\GeneratePdf;
use Maatwebsite\Excel\Facades\Excel;

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

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
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
        if (!$request->has('with_activity') || $request->with_activity) {
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



    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(TransferPurpose $transfer_purpose)
    {
        $transfer_purpose->delete();
        return TransferPurposeResource::make($transfer_purpose)
            ->additional([
                'status' => true,
                'message' => trans("dashboard.general.success_delete")
            ]);
    }


    public function exportPDF(Request $request, GeneratePdf $pdfGenerate)
    {
        $TransferPurposesQuery = TransferPurpose::search($request)
        ->sortBy($request)
        ->get();


        if (!$request->has('created_from')) {
            $createdFrom = TransferPurpose::selectRaw('MIN(created_at) as min_created_at')->value('min_created_at');
        }

        $mpdfPath = $pdfGenerate->newFile()
            ->view(
                'dashboard.exports.transfer_purpose',
                [
                    'transfer_purposes' => $TransferPurposesQuery,
                    'date_from'   => format_date($request->created_from) ?? format_date($createdFrom),
                    'date_to'     => format_date($request->created_to) ?? format_date(now()),
                    'userId'      => auth()->user()->login_id,

                ]
            )
            ->storeOnLocal('TransferPurposes/pdfs/');
        $file  = url('/storage/' . $mpdfPath);

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

        return response()->json([
            'data'   => [
                'file' => $file
            ],
            'status' => true,
            'message' => ''
        ]);
    }
}
