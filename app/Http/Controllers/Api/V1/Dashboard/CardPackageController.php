<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Dashboard\CardPackageRequest;
use App\Http\Resources\Dashboard\CardPackageResource;
use App\Models\CardPackage\CardPackage;
use Illuminate\Http\Request;

class CardPackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * //     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $card_packages = CardPackage::with("translations")->latest()->paginate((int)($request->per_page ?? config("globals.per_page")));
        return CardPackageResource::collection($card_packages)->additional([
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
    public function store(CardPackageRequest $cardPackageRequest)
    {
//        dd($cardPackageRequest->validated());
        $card_package = CardPackage::create($cardPackageRequest->validated());
        $card_package->load("translations");
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
    public function show(CardPackage $card_package)
    {


    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
