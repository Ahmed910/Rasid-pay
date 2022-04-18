<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Dashboard\BankAccountRequest;
use App\Http\Requests\V1\Dashboard\CitizenRequest;
use App\Http\Requests\V1\Dashboard\ReasonRequest;
use App\Http\Resources\Dashboard\CitizenResource;
use App\Models\Attachment;
use App\Models\BankAccount;
use App\Models\Citizen;
use App\Models\User;
use Illuminate\Http\Request;

class CitizenController extends Controller
{

    public function index(Request $request)
    {
        $citizen = Citizen::with('user.bankAccount.bank.translations')->CustomDateFromTo($request)->sortby($request)
            ->latest()->paginate((int)($request->per_page ?? config("globals.per_page")));

        return CitizenResource::collection($citizen)->additional([
            'status' => true,
            'message' => ""
        ]);
    }




    public function store(CitizenRequest  $citizenRequest,BankAccountRequest $bankAccountRequest,BankAccount $bankAccount, Citizen $citizen)
    {

        $userData = $citizenRequest->validated() + ["user_type" => "citizen", 'added_by_id' => auth()->id()];
        $clientData = $citizenRequest->validated();

        $user = user::create($userData);
        $bankAccount->fill($bankAccountRequest->validated())->user()->associate($user)->save();

        $citizen->fill($clientData)->user()->associate($user)->save();
        return CitizenResource::make($citizen)->additional([
            'status' => true, 'message' => trans("dashboard.general.success_add")
        ]);
    }

    public function show(Request $request, $id)
    {
        $citizen = Citizen::where('user_id', $id)->firstOrFail();
        $citizen->load(['user.bankAccount.bank.translations',]);

        return CitizenResource::make($citizen)->additional(['status' => true, 'message' => ""]);
    }


    public function update($id, CitizenRequest $request, BankAccountRequest $bankAccountRequest)
    {
        $citizen = Citizen::where('user_id', $id)->firstOrFail();

        $citizen->user->update($request->validated());
        $citizen->update($request->validated());
        $citizen->user->bankAccount->update($bankAccountRequest->validated());


        return CitizenResource::make($citizen)->additional(['status' => true, 'message' => trans("dashboard.general.success_update")]);
    }

    public function forceDestroy(ReasonRequest $request, $id)
    {
        $user = User::onlyTrashed()->findorfail($id);
        $user->forceDelete();

        return CitizenResource::make($user)
            ->additional([
                'status' => true,
                'message' => trans('dashboard.general.success_delete'),
            ]);
    }


    public
    function destroy(ReasonRequest $request, User $user)
    {

        $user->delete();

        return CitizenResource::make($user)
            ->additional([
                'status' => true,
                'message' => trans('dashboard.general.success_archive'),
            ]);
    }


    public
    function restore(ReasonRequest $request, $id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $user->restore();

        return CitizenResource::make($user)
            ->additional([
                'status' => true,
                'message' => trans('dashboard.general.success_restore'),
            ]);
    }
}
