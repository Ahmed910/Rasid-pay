<?php

namespace App\Http\Controllers\Api\V1\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Mobile\TransactionRequest;
use App\Http\Resources\Api\V1\Mobile\Transactions\TransactionResource;
use App\Models\Transaction;
use App\Services\GeneratePdf;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TransactionController extends Controller
{
    public function index(TransactionRequest $request)
    {
        $transactions = auth()->user()->citizenTransactions()
            ->mobileSearch($request)
            ->whereNotNull('transactionable_type')
            ->customDateFromTo($request)
            ->latest()
            ->paginate((int)($request->per_page ?? config("globals.per_page")));

        return TransactionResource::collection($transactions)
            ->additional([
                'status' => true,
                'message' => ''
            ]);
    }

    /**
     * @param  $id
     * @return App\Http\Resources\Mobile\TransactionResource
     */
    public function show($id)
    {
        $transaction = auth()->user()->citizenTransactions()->whereNotNull('transactionable_type')->findOrFail($id);

        return TransactionResource::make($transaction)
            ->additional([
                'status' => true,
                'message' => ''
            ]);
    }

    public function generatePdfLink($id)
    {
        return response()->json([
            'status' => true,
            'message' => 'Pdf File',
            'data' => [
                'file' => route('summary_file', $id),
            ]
        ]);
    }

    public function getSummaryFile($id)
    {
        $this->checkInvoicesFolderExists();

        $path = $this->createOrGetPdfFile($id);
        return response()->file(
            storage_path(Str::replace(url(''), '', $path))
        );
    }

    private function checkInvoicesFolderExists()
    {
        if (!File::isDirectory(storage_path('app/public/invoices'))) {
            File::makeDirectory(storage_path('app/public/invoices'), 0777, true);
        }
    }

    private function createOrGetPdfFile($transactionId)
    {
        $generatePdfFile = new GeneratePdf();
        $transaction = Transaction::findOrFail($transactionId);

        if ($transaction->summary_path && is_file(storage_path('app/public/' . $transaction->summary_path))) {
            return asset('app/public/' . $transaction->summary_path);
        }

        $path =  $generatePdfFile->newFile()
            ->view('dashboard.exports.mobile.invoice', ['transaction' => $transaction, 'transaction_type' => $transaction->trans_type])
            ->storeOnLocal('invoices/');

        $transaction->update(['summary_path' => $path]);


        return asset('app/public/' . $path);
    }

    public function getTransTypes()
    {
        $data = transform_array_api(Transaction::TRANACTION_TYPES, 'mobile.transaction.transaction_types');

        return response()->json([
            'data' => $data,
            'status' => true,
            'message' => ' '
        ], 200);
    }
}
