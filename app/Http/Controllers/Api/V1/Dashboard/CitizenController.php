<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Resources\Dashboard\CitizenResource;
use App\Models\Citizen;
use App\Models\CitizenPackage;
use Illuminate\Http\Request;

class CitizenController extends Controller
{

    public function index(Request $request)
    {
        if (isset($request->order[0]['column'])) {
            $request['sort'] = ['column' => $request['columns'][$request['order'][0]['column']]['name'], 'dir' => $request['order'][0]['dir']];
        }

        $citizen = Citizen::with(['user', "enabledPackage"])
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

//    public function update(CitizenRequest $request, $id)
//    {
//        $citizen = User::where('user_type', "citizen")->with(["citizenTransactions" => function($q){
//            $q->where("trans_status","pending");
//        }])->findOrFail($id);
//        if ($citizen->citizenTransactions->count()) {
//            $data = [
//                'status' => false,
//                'data' => null,
//                'message' => trans('dashboard.error.something_went_wrong'),
//                'errors' => [
//                    'phone' => [trans('dashboard.general.cant_update_phone_related_with_hold_transactions')]
//                ],
//            ];
//
//            return response()->json( $data, 422);
//        }
//        $citizen->update($request->validated());
//
//        return CitizenResource::make($citizen)->additional(['status' => true, 'message' => trans("dashboard.general.success_update")]);
//    }

    public function enabledPackages()
    {
        $enabledPackages = transform_array_api(CitizenPackage::PACKAGE_TYPES, 'dashboard.package_types');

        return response()->json([
            'data' => $enabledPackages,
            'status' => true,
            'message' =>  '',
        ]);
    }
}
