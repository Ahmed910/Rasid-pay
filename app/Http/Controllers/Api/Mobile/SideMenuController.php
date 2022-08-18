<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Mobile\StaticPageResource;
use App\Models\StaticPage\StaticPage;

class SideMenuController extends Controller
{
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

    public function show($id)
    {
        $sidemenu = StaticPage::where(["show_in_app" => true, "is_active" => true])->findorfail($id);
        return StaticPageResource::make($sidemenu)->additional([
                'status' => true,
                'message' => '']
        );
    }
}
