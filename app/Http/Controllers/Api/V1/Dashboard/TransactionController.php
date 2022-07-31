<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Exports\TransactionExport;
use App\Http\Controllers\Controller;
use App\Http\Resources\Dashboard\Transaction\TransactionResource;
use App\Http\Requests\V1\Dashboard\TransactionRequest;
use App\Http\Resources\Dashboard\Transaction\TransactionCollection;
use App\Models\Client;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\User;
use App\Services\GeneratePdf;
use Maatwebsite\Excel\Facades\Excel;

class TransactionController extends Controller
{

    public function index(Request $request)
    {
        $transactions = Transaction::search($request)
            ->CustomDateFromTo($request)
            ->sortBy($request)
            ->with('citizenPackage', 'toUser', 'fromUser.citizen.enabledPackage', 'transactionable')
            ->paginate((int)($request->per_page ?? config("globals.per_page")));

        return TransactionResource::collection($transactions)
            ->additional([
                'status' => true,
                'message' => "",
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(TransactionRequest $request, Transaction $transaction)
    {
        $additionadData = [];

        $citizen = User::find($request->from_user_id);
        $additionadData['user_identity'] = $citizen->identity_number;

        if (isset($request->to_user_id)) {
            $client = Client::find($request->to_user_id);
            $additionadData['to_user_identity'] = $client->user->identity_number;
        }

        $transaction->fill($request->validated() + $additionadData)->save();

        $transaction = Transaction::find($transaction->id);
        return TransactionResource::make($transaction)
            ->additional([
                'status' => true,
                'message' => __('dashboard.general.success_add')
            ]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $transaction = Transaction::findOrFail($id);
        $activities = [];
        if (!$request->has('with_activity') || $request->with_activity) {
            $activities  = $transaction->activity()
                ->sortBy($request)
                ->paginate((int)($request->per_page ??  config("globals.per_page")));
        }


        return TransactionCollection::make($activities)
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
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        $transaction->delete();
        return TransactionResource::make($transaction)
            ->additional([
                'status' => true,
                'message' => trans('dashboard.general.success_archive'),
            ]);
    }

    /**
     * force Delete card package
     * @param int $id
     */
    public function forceDelete($id)
    {
        $transaction = Transaction::onlyTrashed()->findOrFail($id);
        $transaction->forceDelete();

        return TransactionResource::make($transaction)
            ->additional([
                'status' => true,
                'message' => trans("dashboard.general.success_delete")
            ]);
    }

    public function transactionsStatues()
    {
        $data = transform_array_api(Transaction::TYPES, 'dashboard.transaction.status_cases');

        return response()->json([
            'data' => $data,
            'status' => true,
            'message' => ' '
        ], 200);
    }


    public function exportPDF(Request $request, GeneratePdf $pdfGenerate)
    {
        $TransactionsQuery = Transaction::search($request)
            ->CustomDateFromTo($request)
            ->sortBy($request)
            ->with('citizenPackage', 'toUser', 'fromUser.citizen.enabledPackage', 'transactionable')
            ->get();


        if (!$request->has('created_from')) {
            $createdFrom = Transaction::selectRaw('MIN(created_at) as min_created_at')->value('min_created_at');
        }

        $mpdfPath = $pdfGenerate->newFile()
            ->view(
                'dashboard.exports.transactions',
                [
                    'transactions' => $TransactionsQuery,
                    'date_from'   => format_date($request->created_from) ?? format_date($createdFrom),
                    'date_to'     => format_date($request->created_to) ?? format_date(now()),
                    'userId'      => auth()->user()->login_id,

                ]
            )
            ->storeOnLocal('Transactions/pdfs/');
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
        Excel::store(new TransactionExport($request), 'Transactions/excels/' . $fileName . '.xlsx', 'public');
        $file = url('/storage/' . 'Transactions/excels/' . $fileName . '.xlsx');

        return response()->json([
            'data'   => [
                'file' => $file
            ],
            'status' => true,
            'message' => ''
        ]);
    }
}
