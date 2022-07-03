<?php

namespace App\Http\Controllers\Api\V1\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Mobile\TransactionRequest;
use App\Http\Resources\Api\V1\Mobile\Transactions\TransactionResource;
use App\Services\GeneratePdf;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
                'message' => ''
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
                'message' => ''
            ]);
    }

    public function createOrGetPdfFile($transaction)
    {
        $generatePdfFile = new GeneratePdf();
        $path =  $generatePdfFile->newFile()
            ->view('dashboard.exports.mobile.invoice', ['transaction' => $transaction])
            ->storeOnLocal('invoices/');

        $transaction->update(['summary_path' => $path]);

        return asset('app/public/' . $path);
    }

    public function generatePdfFile($id)
    {
        $this->checkInvoicesFolderExists();
        $transaction = auth()->user()->citizenTransactions()->findOrFail($id);

        if ($transaction->summary_path && is_file(storage_path('app/public/' . $transaction->summary_path)))
            return response()->download(public_path('storage/' . $transaction->summary_path));


        $file = $this->createOrGetPdfFile($transaction);

        return response()->download($file);
    }

    public function generatePdfLink($id)
    {
        $this->checkInvoicesFolderExists();
        $transaction = auth()->user()->citizenTransactions()->findOrFail($id);

        if ($transaction->summary_path && is_file(storage_path($transaction->summary_path))) {
            return response()->json([
                'status' => true,
                'message' => 'Pdf File',
                'data' => [
                    'file' => asset(Str::replace('app/public/', 'storage/', $transaction->summary_path))
                ]
            ]);
        }

        $path = $this->createOrGetPdfFile($transaction);

        return response()->json([
            'status' => true,
            'message' => 'Pdf File',
            'data' => [
                'file' => asset(Str::replace('app/public/', 'storage/', $path))
            ]
        ]);
    }

    private function checkInvoicesFolderExists()
    {
        if (!File::isDirectory(storage_path('app/public/invoices'))) {
            File::makeDirectory(storage_path('app/public/invoices'), 0777, true);
        }
    }
}
