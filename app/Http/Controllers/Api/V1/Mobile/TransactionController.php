<?php

namespace App\Http\Controllers\Api\V1\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Mobile\TransactionRequest;
use App\Http\Resources\Mobile\Transactions\TransactionResource;

class TransactionController extends Controller
{
    public function index(TransactionRequest $request)
    {
        $user = auth('sanctum')->user();

        $transactions = $user->citizenTransactions()
            ->CustomDateFromTo($request)
            ->paginate($request->per_page);

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
        $transaction = auth('sanctum')->user()->citizenTransactions()->findOrFail($id);

        return TransactionResource::make($transaction)
            ->additional([
                'status' => true,
                'message' => 'success'
            ]);
    }
}
