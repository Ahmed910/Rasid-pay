<?php

namespace App\Http\Controllers\Api\Mobile;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Mobile\InvoiceLocalTransferResource;
use App\Models\Transfer;
use Illuminate\Http\Request;

class InvoiceLocalTransferController extends Controller
{
    //
    public function getInvoiceLocalTransfer($id)
    {
        $transfer = Transfer::with('bank_transfer')->findOrFail($id);
        return
        InvoiceLocalTransferResource::make($transfer)->additional(['status' => true, 'message' => ""]);
    }
}
