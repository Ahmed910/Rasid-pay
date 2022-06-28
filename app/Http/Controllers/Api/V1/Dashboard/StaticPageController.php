<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Dashboard\StaticPage\StaticPageResource;
use App\Models\StaticPage\StaticPage;

class StaticPageController extends Controller
{
    public function index(Request $request)
    {
        $staticPages = StaticPage::search($request)
            ->ListsTranslations('name')
            ->CustomDateFromTo($request)
            ->sortBy($request)
            ->paginate((int)($request->per_page ?? config("globals.per_page")));


        return StaticPageResource::collection($staticPages)->additional([
            'status'=>true,
            'message'=>''
        ]);

    }

    public function show(Request $request ,$id)
    {
        $staticPage  = StaticPage::withTrashed()->findOrFail($id);
        $activities = [];
        if (!$request->has('with_activity') || $request->with_activity) {
            $activities  = $staticPage->activity()
                ->sortBy($request)
                ->paginate((int)($request->per_page ??  config("globals.per_page")));
        }

        return StaticPageResource::make($activities)->additional([
            'status' => true,
            'message' => ''
        ]);
    }

    public function destroy(StaticPage $staticPage)
    {
        $staticPage->delete();

        return StaticPageResource::make($staticPage)->additional([
            'status' => true,
            'message' => trans('dashboard.general.success_archive'),
        ]);
    }

}
