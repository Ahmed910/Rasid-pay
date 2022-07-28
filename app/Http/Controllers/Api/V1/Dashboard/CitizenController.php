<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Models\User;
use App\Models\Citizen;
use Illuminate\Http\Request;
use App\Models\CitizenPackage;
use App\Http\Controllers\Controller;
use App\Http\Resources\Dashboard\Citizen\CitizenResource;
use App\Http\Resources\Dashboard\Citizen\CitizenCollection;
use App\Http\Requests\V1\Dashboard\UpdateCitizenStatusRequest;

class CitizenController extends Controller
{

    public function index(Request $request)
    {
        if (isset($request->order[0]['column'])) {
            $request['sort'] = ['column' => $request['columns'][$request['order'][0]['column']]['name'], 'dir' => $request['order'][0]['dir']];
        }

        $citizen = Citizen::with(['user', "enabledPackage"])
        ->whereHas('user',fn ($q) => $q->where('register_status' , 'completed'))
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
        $activities = [];
        if (!$request->has('with_activity') || $request->with_activity) {
            $activities  = $citizen->activity()
                ->sortBy($request)
                ->paginate((int)($request->per_page ??  config("globals.per_page")));
        }

        return CitizenCollection::make($activities)
            ->additional([
                'status' => true,
                'message' => ''
            ]);
    }


    public function update(UpdateCitizenStatusRequest $request, $id)
    {
        $citizen = User::where('user_type', "citizen")->findOrFail($id);
        $citizen->update($request->validated());
        return CitizenResource::make($citizen->citizen->load('user'))->additional([
            'status' => true,
            'message' => "dashboard.general.success_update"
        ]);
    }
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
