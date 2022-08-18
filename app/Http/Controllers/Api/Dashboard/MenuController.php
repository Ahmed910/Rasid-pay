<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\MenuRequest;
use App\Http\Resources\Api\Dashboard\Menu\MenuCollection;
use App\Http\Resources\Api\Dashboard\Menu\MenuResource;
use Illuminate\Http\Request;
use App\Models\Menu\Menu;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $menus = Menu::with('children')->parent()->oldest('order')->get();
        $filtered = $menus->filter(function($item){
            return auth()->user()->hasPermissions($item->uri) && $item->children->count();
        });

        return MenuCollection::make($filtered)->additional([
            'status' => true,
            'message' => "",
        ]);
    }

    public function store(MenuRequest $request,Menu $menu)
    {
        $menu->fill($request->validated()+['updated_at'=>now()])->save();

        return MenuResource::make($menu)->additional([
            'status' => true,
            'message' => trans('dashboard.general.success_add'),
        ]);
    }

    public function show(Menu $menu)
    {
        return MenuResource::make($menu)->additional([
            'status' => true,
            'message' => '',
        ]);
    }

    public function update(MenuRequest $request,Menu $menu)
    {
        $menu->update($request->validated());

        return MenuResource::make($menu)->additional([
            'status' => true,
            'message' => trans('dashboard.general.success_update'),
        ]);
    }

    public function destroy(Menu $menu)
    {
        $menu->delete();

        return MenuResource::make($menu)->additional([
            'status' => true,
            'message' => trans('dashboard.general.success_delete'),
        ]);
    }

}
