<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\MoneyRequest;
use App\Models\User;
use App\Http\Requests\MobileMoneyReqRequest;
use App\Http\Resources\Api\Mobile\MoneyRequestResource;

class MoneyRequestController extends Controller
{
    public function store(MoneyReqRequest $request, MoneyRequest $money)
    {
       $money->fill($request->validated() + ['added_by_id' => auth()->id()])->save();

       $from_user = User::where('phone',$request->phone)->first();

       $transaction = $money->transaction()->create([
            'amount' => $request->amount_required,
            'transfer_type' => 'money_request',
            'to_user_id' => auth()->id(),
            'from_user_id'=> $from_user ? $from_user->id : "",
           'trans_number' => generate_unique_code(Transaction::class,'trans_number',10,'numbers')
        ]);

        return MoneyRequestResource::make($money)
            ->additional([
                'status' => true,
                'message' => trans("dashboard.general.success_add")
            ]);
    }

}
