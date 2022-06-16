<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Dashboard\CardPackageRequest;
use App\Http\Requests\V1\Dashboard\CardPackageUpdateRequest;
use App\Http\Resources\Dashboard\PackageResource;
use App\Http\Resources\Dashboard\MainPackageResource;
use App\Http\Resources\Dashboard\SimpleUserResource;
use App\Models\Package\Package;
use App\Models\User;
use Illuminate\Http\Request;

class ClientPackageController extends Controller
{
    public function index(Request $request)
    {
        if (isset($request->order[0]['column'])) {
            $request['sort'] = ['column' => $request['columns'][$request['order'][0]['column']]['name'], 'dir' => $request['order'][0]['dir']];
        }
        $packages = User::has('clientPackages')->where("user_type", "client")
            ->search($request)
            ->sortBy($request)
            ->with("clientPackages")
            ->paginate((int)($request->per_page ?? config("globals.per_page")));
        $clients = User::has('clientPackages')->where("user_type", "client")->pluck('users.fullname', 'users.id');
        return PackageResource::collection($packages)->additional([
            'status' => true,
            'message' => ""
        ]);
    }

    public function getclients(Request $request)
    {
        $fileds = $this->validate($request, [
            "has_card" => "required|boolean"
        ]);
        $clients = $request->has_card
            ? User::has('clientPackages')->where("user_type", "client")->select('users.fullname', 'users.id')->get()
            : User::doesntHave('clientPackages')->where("user_type", "client")->select('users.fullname', 'users.id')->get();;
        return SimpleUserResource:: collection($clients)->additional([
            'status' => true,
            'message' => ""
        ]);
    }

    public function store(CardPackageUpdateRequest $request)
    {
        $client = User::where('user_type', 'client')->findOrFail($request->client_id);
        $client->clientPackages()->sync($request->discounts);
        return PackageResource::make($client)->additional([
            'status' => true,
            'message' => __('dashboard.package.discount_success_add')
        ]);
    }

    public function show($id)
    {

        $client_package = [];
        $client = User::has('clientPackages')->where("user_type", "client")->findOrFail($id);
        foreach ($client->clientPackages as $key => $clientPackage) {
            $client_package[$key]['package_id'] = $clientPackage->pivot->package_id;
            $client_package[$key]['package_discount'] = $clientPackage->pivot->package_discount;
            $client_package[$key]['type'] = lcfirst($clientPackage->translate('en')->name . '_card');
        }
        return response()->json([
            'data' => [
                'discounts' => $client_package,
                'fullname' => $client->fullname,
            ],
            'status' => true,
            'message' => ""
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\PackageRequest $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(CardPackageUpdateRequest $request, $client_id)
    {
        $client = User::where('user_type', 'client')->findOrFail($client_id);
        $client->clientPackages()->sync($request->discounts);
        return PackageResource::make($client)->additional([
            'status' => true,
            'message' => trans("dashboard.package.discount_success_update")
        ]);
    }


    public function getMainPackages()
    {
        $packages = Package::where('is_active', 1)->get();
        return MainPackageResource::collection($packages)->additional([
            'status' => true,
            'message' => ""
        ]);
    }
}
