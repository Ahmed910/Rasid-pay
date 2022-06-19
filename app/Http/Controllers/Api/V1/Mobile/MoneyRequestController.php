<?php

namespace App\Http\Controllers\Api\V1\Mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MoneyRequest;
use App\Models\User;
use App\Http\Requests\V1\Mobile\MoneyReqRequest;
use App\Http\Resources\Mobile\MoneyRequestResource;

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
        ]);

        return MoneyRequestResource::make($money)
            ->additional([
                'status' => true,
                'message' => trans("dashboard.general.success_add")
            ]);
    }

}
