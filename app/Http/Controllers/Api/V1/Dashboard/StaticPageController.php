<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Dashboard\StaticPageRequest;
use App\Http\Resources\Dashboard\StaticPages\StaticPageResource;
use App\Models\StaticPage\StaticPage;
use Illuminate\Http\Request;

class StaticPageController extends Controller
{

    public function store(StaticPageRequest $request, StaticPage $static_page)
    {
        $static_page->fill($request->validated() + ['added_by_id' => auth()->id()])->save();

        return StaticPageResource::make($static_page)
            ->additional([
                'status'  => true,
                'message' => trans("dashboard.general.success_add")
            ]);
    }


    public function update(StaticPageRequest $request, $id)
    {
        $staticPage = StaticPage::findOrFail($id);
        $staticPage->fill($request->validated() + ['updated_at' => now()])->save();


        return StaticPageResource::make($staticPage)
            ->additional([
                'status'  => true,
                'message' => trans("dashboard.general.success_update")
            ]);;
    }



}
