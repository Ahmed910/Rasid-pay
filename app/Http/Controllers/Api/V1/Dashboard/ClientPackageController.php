<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Dashboard\CardPackageRequest;
use App\Http\Requests\V1\Dashboard\CardPackageUpdateRequest;
use App\Http\Resources\Dashboard\PackageResource;
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

    public function store(CardPackageRequest $request)
    {
        $client = User::where('user_type', 'client')->findOrFail($request->client_id);
        $client->clientPackages()->sync($request->discounts);
        return PackageResource::make($client)->additional([
            'status' => true,
            'message' => __('dashboard.package.discount_success_add', ['client' => $client->fullname])
        ]);
    }

    /**
     * Display the specified resource.
     *
     * //     * @param int $id
     * //     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $package = Package::withTrashed()->findOrFail($id)->client;
        return PackageResource::make($package)
            ->additional([
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
    public function update(CardPackageUpdateRequest $request,$client_id)
    {
        $client = User::where('user_type', 'client')->findOrFail($client_id);
        $client->clientPackages()->sync($request->discounts);
        return PackageResource::make($client)->additional([
            'status' => true,
            'message' => trans("dashboard.general.success_update")
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Package $package)
    {
        $package->delete();
        return PackageResource::make($package)
            ->additional([
                'status' => true,
                'message' => trans('dashboard.general.success_archive'),
            ]);
    }

    /**
     * return archived card packages
     */
    public function archive(Request $request)
    {
        $packages = Package::onlyTrashed()->with("translations")->latest()->paginate((int)($request->per_page ?? config("globals.per_page")));
        return PackageResource::collection($packages)->additional([
            'status' => true,
            'message' => ""

        ]);
    }

    /**
     * restore deleted card package
     * @param int $id
     */
    public function restore($id)
    {
        $package = Package::onlyTrashed()->findOrFail($id);
        $package->restore();

        return PackageResource::make($package)
            ->additional([
                'status' => true,
                'message' => trans('dashboard.general.restore')
            ]);
    }

    /**
     * force Delete card package
     * @param int $id
     */
    public function forceDelete($id)
    {
        $package = Package::onlyTrashed()->findOrFail($id);
        $package->forceDelete();

        return PackageResource::make($package)
            ->additional([
                'status' => true,
                'message' => trans("dashboard . general . success_delete")
            ]);
    }
}
