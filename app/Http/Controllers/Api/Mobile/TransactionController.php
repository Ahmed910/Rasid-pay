<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Mobile\TransactionRequest;
use App\Http\Resources\Api\Mobile\Transactions\TransactionResource;
use App\Models\Transaction;
use App\Services\GeneratePdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
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

 $wallet_transfer_method = [
            'phone' => $transaction->transactionable?->wallet_transfer_method == 'phone' ? ($transaction->toUser?->phone ?? $transaction->transactionable->phone) : "",
            'identity_number' => $transaction->transactionable?->wallet_transfer_method == 'identity_number' ? $transaction->toUser?->identity_number : "",
            'wallet_number' => $transaction->transactionable?->wallet_transfer_method == 'wallet_number' ? $transaction->toUser?->citizenWallet?->wallet_number : "",
        ];


        $path =  $generatePdfFile->newFile()
            ->mobileView('dashboard.exports.mobile.invoice',
                ['transaction' => $transaction, 'transaction_type' => $transaction->trans_type,'wallet_transfer_method'=>$wallet_transfer_method])
            ->storeOnLocal('invoices/');

       DB::table('transactions')->update(['summary_path' => $path]);


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
