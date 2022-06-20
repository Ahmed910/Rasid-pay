<?php

namespace App\Http\Controllers\Api\V1\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Mobile\TransactionRequest;
use App\Http\Resources\Mobile\Transactions\TransactionResource;
use App\Services\GeneratePdf;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class TransactionController extends Controller
{
    public function index(TransactionRequest $request)
    {
        $transactions = auth()->user()->citizenTransactions()
            ->CustomDateFromTo($request)
            ->paginate((int)($request->per_page ?? config("globals.per_page")));

        return TransactionResource::collection($transactions)
            ->additional([
                'status' => true,
                'message' => 'success'
            ]);
    }

    /**
     * @param  $id
     * @return App\Http\Resources\Mobile\TransactionResource
     */
    public function show($id)
    {
        $transaction = auth()->user()->citizenTransactions()->findOrFail($id);

        return TransactionResource::make($transaction)
            ->additional([
                'status' => true,
                'message' => 'success'
            ]);
    }

    public function generatePdfFile($id, GeneratePdf $generatePdfFile)
    {
        $this->checkInvoicesFolderExists();
        $transaction = auth()->user()->citizenTransactions()->findOrFail($id);

        if ($transaction->summary_path && is_file(storage_path('app/' . $transaction->summary_path)))
            return Storage::download($transaction->summary_path);

        $path =  $generatePdfFile->newFile()
            ->view('dashboard.exports.mobile.invoice', ['transaction' => $transaction])
            ->storeOnLocal('invoices/');

        $transaction->update(['summary_path' => $path]);

        return Storage::download($path);
    }

    private function checkInvoicesFolderExists()
    {
        if (!File::isDirectory(storage_path('app/invoices'))) {
            File::makeDirectory(storage_path('app/invoices'), 0777, true);
        }
    }
}
