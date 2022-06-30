<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Dashboard\StaticPages\StaticPageResource;
use App\Http\Requests\V1\Dashboard\StaticPageRequest;
use App\Http\Resources\Dashboard\StaticPages\StaticPageCollection;
use App\Models\StaticPage\StaticPage;

class StaticPageController extends Controller
{
    public function index(Request $request)
    {
        $static_pages = StaticPage::search($request)
            ->ListsTranslations('name')
            ->CustomDateFromTo($request)
            ->with('translations')
            ->addSelect('static_pages.created_at', 'static_pages.is_active')
            ->sortBy($request)
            ->paginate((int)($request->per_page ?? config("globals.per_page")));


        return StaticPageResource::collection($static_pages)->additional([
            'status'=>true,
            'message'=>''
        ]);

    }

    public function store(StaticPageRequest $request, StaticPage $static_page)
    {
        $static_page->fill($request->validated() + ['added_by_id' => auth()->id()])->save();

        return StaticPageResource::make($static_page)
            ->additional([
                'status'  => true,
                'message' => trans("dashboard.general.success_add")
            ]);
    }

    public function show(Request $request ,$id)
    {
        $static_page  = StaticPage::withTrashed()->findOrFail($id);
        $activities = [];
        if (!$request->has('with_activity') || $request->with_activity) {
            $activities  = $static_page->activity()
                ->sortBy($request)
                ->paginate((int)($request->per_page ??  config("globals.per_page")));
        }

        return StaticPageCollection::make($activities)->additional([
            'status' => true,
            'message' => ''
        ]);
    }

    public function update(StaticPageRequest $request, StaticPage $static_page)
    {
        $static_page->fill($request->validated() + ['updated_at' => now()])->save();

        return StaticPageResource::make($static_page)
            ->additional([
                'status'  => true,
                'message' => trans("dashboard.general.success_update")
            ]);;
    }

    public function destroy(StaticPage $static_page)
    {
        $static_page->delete();

        return StaticPageResource::make($static_page)->additional([
            'status' => true,
            'message' => trans('dashboard.general.success_archive'),
        ]);
    }


}
