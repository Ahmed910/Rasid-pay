<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Dashboard\BankAccountRequest;
use App\Http\Requests\V1\Dashboard\CitizenRequest;
use App\Http\Requests\V1\Dashboard\ReasonRequest;
use App\Http\Resources\Dashboard\CitizenResource;
use App\Models\BankAccount;
use App\Models\Citizen;
use App\Models\User;
use Illuminate\Http\Request;

class CitizenController extends Controller
{

    public function index(Request $request)
    {
        if (isset($request->order[0]['column'])) {
            $request['sort'] = ['column' => $request['columns'][$request['order'][0]['column']]['name'], 'dir' => $request['order'][0]['dir']];
        }
        $dir = $request->sort["dir"] ?? null;
        $sortcol = isset($request->sort["column"]) ? $request->sort["column"] : null;
        if (isset($request->sort["column"]) && in_array($request->sort["column"], Citizen::user_searchable_Columns)) $sortcol = "user." . $request->sort["column"];
        if (isset($request->sort["column"]) && key_exists($request->sort["column"], Citizen::ENABLEDCARD_SORTABLE_COLUMS)) $sortcol = Citizen::ENABLEDCARD_SORTABLE_COLUMS[$sortcol];
        $citizen = Citizen::with(['user', "enabledCard"])->CustomDateFromTo($request)->
        search($request)
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
