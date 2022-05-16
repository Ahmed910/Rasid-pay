<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Models\User;
use App\Models\Citizen;
use App\Models\BankAccount;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CardPackage\CardPackage;
use App\Http\Requests\V1\Dashboard\ReasonRequest;
use App\Http\Resources\Dashboard\CitizenResource;
use App\Http\Requests\V1\Dashboard\CitizenRequest;
use App\Http\Requests\V1\Dashboard\BankAccountRequest;
use App\Http\Resources\Dashboard\SimpleCardPackageResource;

class CitizenController extends Controller
{

    public function index(Request $request)
    {
        if (isset($request->order[0]['column'])) {
            $request['sort'] = ['column' => $request['columns'][$request['order'][0]['column']]['name'], 'dir' => $request['order'][0]['dir']];
        }
        $dir = $request->sort["dir"] ?? null;
        $sortcol = isset($request->sort["column"]) ? $request->sort["column"] : null;
        if (isset($request->sort["column"]) && in_array($request->sort["column"], Citizen::USER_SEARCHABLE_COLUMNS)) $sortcol = "user." . $request->sort["column"];
        if (isset($request->sort["column"]) && key_exists($request->sort["column"], Citizen::ENABLEDCARD_SORTABLE_COLUMNS)) $sortcol = Citizen::ENABLEDCARD_SORTABLE_COLUMNS[$sortcol];
        $citizen = Citizen::with(['user', "enabledCard.cardPackage"])->CustomDateFromTo($request)->search($request)
            ->latest()->paginate((int)($request->per_page ?? config("globals.per_page")))->sortBy($sortcol, SORT_REGULAR, $dir == "desc");;
        return CitizenResource::collection($citizen)->additional([
            'status' => true,
            'message' => ""
        ]);
    }


    public function store(CitizenRequest $citizenRequest, BankAccountRequest $bankAccountRequest, BankAccount $bankAccount, Citizen $citizen)
    {

        $userData = $citizenRequest->validated() + ["user_type" => "citizen", 'added_by_id' => auth()->id()];
        $clientData = $citizenRequest->validated();

        $user = user::create($userData);
        $bankAccount->fill($bankAccountRequest->validated())->user()->associate($user)->save();

        $citizen->fill($clientData)->user()->associate($user);
        $citizen->saveQuietly();
        $citizen->load("enabledCard");
        return CitizenResource::make($citizen)->additional([
            'status' => true, 'message' => trans("dashboard.general.success_add")
        ]);
    }

    public function show(Request $request, $id)
    {
        $citizen = Citizen::where('user_id', $id)->with("user", "enabledCard")->firstOrFail();


        return CitizenResource::make($citizen)->additional(['status' => true, 'message' => ""]);
    }


    public function update($id, CitizenRequest $request, BankAccountRequest $bankAccountRequest)
    {
        $citizen = Citizen::where('user_id', $id)->firstOrFail();

        $citizen->user->update($request->validated() + ['updated_at' => now()]);
        !$citizen->user->wasChanged() ? $citizen->update($request->validated()) : $citizen->fill($request->validated())->saveQuietly();
        $citizen->user->bankAccount->update($bankAccountRequest->validated());


        return CitizenResource::make($citizen)->additional(['status' => true, 'message' => trans("dashboard.general.success_update")]);
    }

    public function updatePhone($id, Request $request)
    {
        $request->merge(["full_phone" => $request->country_code . $request->phone]);
        $fileds =   $this->validate($request, [
            "country_code" => "required|in:" . countries_list(),
            "phone" => ["required", "not_regex:/^{$request->country_code}/", "numeric", "digits_between:7,20", "required_with:country_code"],
            "full_phone" => ["unique:users,phone," . @$id],

        ]);
        
        $citizen = Citizen::where('user_id', $id)->firstOrFail();
        $citizen->user->update($fileds + ['updated_at' => now()]);

        return CitizenResource::make($citizen)->additional(['status' => true, 'message' => trans("dashboard.general.success_update")]);
    }

    public function enabledCards()
    {
        $enabledCards = CardPackage::whereHas("citizenCards")->ListsTranslations("name")->select('card_packages.id')->get();

        return response()->json([
            'data' => SimpleCardPackageResource::collection($enabledCards),
            'status' => true,
            'message' =>  '',
        ]);
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


    public function destroy(ReasonRequest $request, User $user)
    {

        $user->delete();

        return CitizenResource::make($user)
            ->additional([
                'status' => true,
                'message' => trans('dashboard.general.success_archive'),
            ]);
    }


    public function restore(ReasonRequest $request, $id)
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
