<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Dashboard\CardPackageRequest;
use App\Http\Resources\Dashboard\CardPackageResource;
use App\Http\Resources\Dashboard\SimpleUserResource;
use App\Models\CardPackage\CardPackage;
use App\Models\User;
use Illuminate\Http\Request;

class CardPackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * //     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (isset($request->order[0]['column'])) {
            $request['sort'] = ['column' => $request['columns'][$request['order'][0]['column']]['name'], 'dir' => $request['order'][0]['dir']];
        }
        $card_packages = User::has('cardPackage')->where("user_type", "client")
            ->search($request)
            ->sortBy($request)
            ->with("cardPackage")
            ->paginate((int)($request->per_page ?? config("globals.per_page")));
        $clients = User::has('cardPackage')->where("user_type", "client")->pluck('users.fullname', 'users.id');
        return CardPackageResource::collection($card_packages)->additional([
            'status' => true,
            'message' => ""
        ]);
    }

    public function getclients(Request $request)
    {
        $clients = User::has('cardPackage')->where("user_type", "client")->select('users.fullname', 'users.id')->get();
        return SimpleUserResource:: collection($clients)->additional([
            'status' => true,
            'message' => ""
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * //     * @param \Illuminate\Http\Request $request
     * //     * @return \Illuminate\Http\Response
     */
    public function store(CardPackageRequest $request, CardPackage $card_package)
    {
        $card_package->fill($request->validated() + ['added_by_id' => auth()->id()])->save();
        $card_package->load(['images', 'addedBy']);
        return CardPackageResource::make($card_package)->additional([
            'status' => true,
            'message' => ""
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
        $card_package = CardPackage::withTrashed()->findOrFail($id)->load('translations');
        return CardPackageResource::make($card_package)
            ->additional([
                'status' => true,
                'message' => ""
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\CardPackageRequest $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(CardPackageRequest $request, CardPackage $card_package)
    {
        $card_package->fill($request->validated() + ['updated_at' => now()])->save();
        $card_package->load(['images', 'addedBy']);
        return CardPackageResource::make($card_package)
            ->additional([
                'status' => true,
                'message' => trans("dashboard.general.success_update")
            ]);;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(CardPackage $card_package)
    {
        $card_package->delete();
        return CardPackageResource::make($card_package)
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
        $card_packages = CardPackage::onlyTrashed()->with("translations")->latest()->paginate((int)($request->per_page ?? config("globals.per_page")));
        return CardPackageResource::collection($card_packages)->additional([
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
        $card_package = CardPackage::onlyTrashed()->findOrFail($id);
        $card_package->restore();

        return CardPackageResource::make($card_package)
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
        $card_package = CardPackage::onlyTrashed()->findOrFail($id);
        $card_package->forceDelete();

        return CardPackageResource::make($card_package)
            ->additional([
                'status' => true,
                'message' => trans("dashboard.general.success_delete")
            ]);
    }
}
