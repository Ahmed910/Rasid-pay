<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Resources\Dashboard\TransactionResource;
use App\Http\Requests\V1\Dashboard\TransactionRequest;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\User;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $transactions = Transaction::search($request)
            ->CustomDateFromTo($request)
            ->sortBy($request)
            ->with('card', 'client.user', 'citizen')
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TransactionRequest $request, Transaction $transaction)
    {
        $additionadData = [];

        $citizen = User::find($request->from_user_id);
        $additionadData['user_identity'] = $citizen->identity_number;

        if (isset($request->to_user_id)) {
            $user = User::find($request->to_user_id);
            $additionadData['to_user_identity'] = $user->identity_number;
        }

        $transaction->fill($request->validated() + $additionadData)->save();

        $transaction = Transaction::find($transaction->id);
        return TransactionResource::make($transaction)
            ->additional([
                'status' => true,
                'message' =>  __('dashboard.general.success_add')
            ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $transaction  = Transaction::findOrFail($id);

        return TransactionResource::make($transaction)
            ->additional([
                'status' => true,
                'message' => trans("dashboard.general.show")
            ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
    //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        $transaction->delete();
        return TransactionResource::make($transaction)
            ->additional([
                'status' => true,
                'message' =>  trans('dashboard.general.success_archive'),
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
}
