<?php

namespace App\Http\Controllers\Blade\Dashboard;

use App\Models\Citizen;
use App\Models\Package\Package;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\Dashboard\CitizenPhoneRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\Blade\Dashboard\Citizen\CitizenCollection;

class CitizenController extends Controller
{
    public function index(Request $request)
    {
        if (isset($request->order[0]['column'])) {
            $request['sort'] = ['column' => $request['columns'][$request['order'][0]['column']]['name'], 'dir' => $request['order'][0]['dir']];
        }

        if ($request->ajax()) {
            $citizensQuery = Citizen::with(["user.citizenPackages", 'enabledPackage'])->search($request);
            $citizenCount = $citizensQuery->count();

            $citizens = $citizensQuery->skip($request->start)
                ->take(($request->length == -1) ? $citizenCount : $request->length)
                ->sortBy($request)
                ->get();

            return CitizenCollection::make($citizens)
                ->additional(['total_count' => $citizenCount]);
        }

        $packages = Package::get();
        return view('dashboard.citizen.index',compact('packages'));
    }

    public function update(CitizenPhoneRequest $request, $id)
    {
        $citizen = User::where('user_type', "citizen")->with(["citizenTransactions" => function($q){
            $q->where("trans_status","pending");
        }])->findOrFail($id);
        if($citizen->citizenTransactions->count()){
            return response()->json(['status' => false, 'message' => trans("dashboard.general.cant_update_phone_related_with_hold_transactions"),'data' => null],422);
        }
        $citizen->update($request->validated());
        return response()->json(['message' => __('dashboard.general.success_update')]);
    }
}
