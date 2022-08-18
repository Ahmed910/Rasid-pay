<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Exports\StaticPageExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\ReasonRequest;
use App\Http\Requests\Dashboard\StaticPageRequest;
use App\Http\Resources\Api\Dashboard\StaticPages\StaticPageCollection;
use App\Http\Resources\Api\Dashboard\StaticPages\StaticPageResource;
use App\Models\ActivityLog;
use App\Models\StaticPage\StaticPage;
use App\Services\GeneratePdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Traits\Loggable;
class StaticPageController extends Controller
{
    public function index(Request $request)
    {
        $staticPages = StaticPage::search($request)
            ->ListsTranslations('name')
            ->customDateFromTo($request)
            ->with('translations')
            ->addSelect('static_pages.created_at', 'static_pages.is_active', 'static_pages.show_in_app', 'static_pages.show_in_website')
            ->sortBy($request)
            ->paginate((int)($request->per_page ?? config("globals.per_page")));


        return StaticPageResource::collection($staticPages)->additional([
            'status' => true,
            'message' => ''
        ]);

    }

    public function store(StaticPageRequest $request, StaticPage $staticPage)
    {
        $staticPage->fill($request->validated() + ['added_by_id' => auth()->id()])->save();

        return StaticPageResource::make($staticPage)
            ->additional([
                'status' => true,
                'message' => trans("dashboard.general.success_add")
            ]);
    }

    public function show(Request $request, $id)
    {
        $staticPage = StaticPage::findOrFail($id);
        $activities = [];
        if ((!$request->has('with_activity') || $request->with_activity) && $request->routeIs('*.show')) {
            $activities = $staticPage->activity()
                ->sortBy($request)
                ->paginate((int)($request->per_page ?? config("globals.per_page")));
        }

        return StaticPageCollection::make($activities)->additional([
            'status' => true,
            'message' => ''
        ]);
    }

    public function update(StaticPageRequest $request, $id)
    {
        $staticPage = StaticPage::findOrFail($id);

        if ($staticPage->link()->exists() && $request->is_active == 0) {
            return response()->json([
                'status' => false,
                'message' => trans("dashboard.static_page.validation.can_not_be_deactivated"),
                'data' => null
            ], 422);
        }
        $staticPage->fill($request->validated() + ['updated_at' => now()])->save();

        return StaticPageResource::make($staticPage)
            ->additional([
                'status' => true,
                'message' => trans("dashboard.general.success_update")
            ]);;
    }

    public function destroy(StaticPage $staticPage, ReasonRequest $reasonRequest)
    {
        if ($staticPage->link()->exists()) {
            return response()->json([
                'status' => false,
                'message' => trans("dashboard.static_page.validation.can_not_be_deleted_has_link"),
                'data' => null
            ], 422);
        }
        $staticPage->delete();

        return StaticPageResource::make($staticPage)->additional([
            'status' => true,
            'message' => trans('dashboard.general.success_delete'),
        ]);
    }

    public function getAllStaticPages(Request $request)
    {
        $staticPages = StaticPage::where('is_active', true)->search($request)
            ->ListsTranslations('name')
            ->customDateFromTo($request)
            ->with('translations')
            ->addSelect('static_pages.created_at', 'static_pages.is_active')
            ->sortBy($request)->get();

        return StaticPageResource::collection($staticPages)->additional([
            'status' => true,
            'message' => ''
        ]);
    }

    public function exportPDF(Request $request, GeneratePdf $generatePdf)
    {
        $StaticPagesQuery = StaticPage::search($request)
            ->ListsTranslations('name')
            ->customDateFromTo($request)
            ->addSelect(
                'static_pages.*'
            )
            ->sortBy($request)
            ->get();

        Loggable::addGlobalActivity(StaticPage::class, $request->query(), ActivityLog::EXPORT, 'index');

        if (!$request->has('created_from')) {
            $createdFrom = StaticPage::selectRaw('MIN(created_at) as min_created_at')->value('min_created_at');
        }

        $chunk = 200;
        $names = [];
        foreach (($StaticPagesQuery->chunk($chunk)) as $key => $rows) {
            $names[] = base_path('storage/app/public/') . $generatePdf->newFile()
                    ->setHeader(trans('dashboard.static_page.static_pages'), $createdFrom)
                    ->view('dashboard.exports.static_page', $rows, $key, $chunk)
                    ->storeOnLocal('static_pages/pdfs/');
        }

        $file = GeneratePdf::mergePdfFiles($names, 'static_pages/pdfs/static_pages.pdf');

        return response()->json([
            'data' => [
                'file' => $file
            ],
            'status' => true,
            'message' => ''
        ]);
    }

    public function exportExcel(Request $request)
    {
        $fileName = uniqid() . time();
        Excel::store(new StaticPageExport($request), 'StaticPages/excels/' . $fileName . '.xlsx', 'public');
        $file = url('/storage/' . 'StaticPages/excels/' . $fileName . '.xlsx');
        Loggable::addGlobalActivity(StaticPage::class, $request->query(), ActivityLog::EXPORT, 'index');

        return response()->json([
            'data' => [
                'file' => $file
            ],
            'status' => true,
            'message' => ''
        ]);
    }

}
