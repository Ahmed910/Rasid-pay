<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Dashboard\TransferPurposeRequest;
use App\Http\Resources\Dashboard\TransferPurpose\TransferPurposeResource;
use App\Models\TransferPurpose\TransferPurpose;
use Illuminate\Http\Request;

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

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $transfer_purpose = TransferPurpose::findOrFail($id);
        return TransferPurposeResource::make($transfer_purpose)->additional([
            'message' => '',
            'status' => true
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
                'message' => trans("dashboard.general.success_archive")
            ]);
    }
}
