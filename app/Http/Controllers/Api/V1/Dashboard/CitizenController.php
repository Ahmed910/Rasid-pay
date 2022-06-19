<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Models\User;
use App\Models\Citizen;
use App\Models\BankAccount;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Package\Package;
use App\Http\Requests\V1\Dashboard\ReasonRequest;
use App\Http\Resources\Dashboard\CitizenResource;
use App\Http\Requests\V1\Dashboard\CitizenRequest;
use App\Http\Requests\V1\Dashboard\BankAccountRequest;

class CitizenController extends Controller
{

    public function index(Request $request)
    {
        if (isset($request->order[0]['column'])) {
            $request['sort'] = ['column' => $request['columns'][$request['order'][0]['column']]['name'], 'dir' => $request['order'][0]['dir']];
        }

        $citizen = Citizen::with(['user', "enabledPackage.package"])
            ->CustomDateFromTo($request)->search($request)->sortBy($request)
            ->paginate((int)($request->per_page ?? config("globals.per_page")));

        return CitizenResource::collection($citizen)->additional([
            'status' => true,
            'message' => ""
        ]);
    }



    public function show(Request $request, $id)
    {
        $citizen = Citizen::where('user_id', $id)->with("user", "enabledPackage")->firstOrFail();

        return CitizenResource::make($citizen)->additional(['status' => true, 'message' => ""]);
    }

    public function update(CitizenRequest $request, $id)
    {
        $citizen = User::where('user_type', "citizen")->with(["citizenTransactions" => function($q){
            $q->where("trans_status","pending");
        }])->findOrFail($id);
        if($citizen->citizenTransactions->count()){
            return response()->json(['status' => true, 'message' => trans("dashboard.general.success_update"),'data' => null],422);
        }
        $citizen->update($request->validated());

        return CitizenResource::make($citizen)->additional(['status' => true, 'message' => trans("dashboard.general.success_update")]);
    }

    public function enabledPackages()
    {
        $enabledPackages = Package::select('id')
        ->listsTranslations('name')->get();
        return response()->json([
            'data' => $enabledPackages,
            'status' => true,
            'message' =>  '',
        ]);
    }

}
