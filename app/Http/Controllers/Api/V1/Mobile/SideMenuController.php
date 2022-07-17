<?php

namespace App\Http\Controllers\Api\V1\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\Mobile\StaticPageResource;
use App\Models\StaticPage\StaticPage;
use Illuminate\Http\Request;

class SideMenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $side_menus = StaticPage::where(["show_in_app" => true, "is_active" => true])
            ->ListsTranslations("name", "description")
            ->get();
        return StaticPageResource::collection($side_menus)->additional([
                'status' => true,
                'message' => '']
        );

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sidemenu = StaticPage::where(["show_in_app" => true, "is_active" => true])->findorfail($id);
        return StaticPageResource::make($sidemenu)->additional([
                'status' => true,
                'message' => '']
        );;
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
