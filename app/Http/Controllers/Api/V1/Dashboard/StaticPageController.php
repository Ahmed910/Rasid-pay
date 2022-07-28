<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Exports\StaticPageExport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Dashboard\StaticPages\StaticPageResource;
use App\Http\Requests\V1\Dashboard\StaticPageRequest;
use App\Http\Resources\Dashboard\StaticPages\StaticPageCollection;
use App\Models\StaticPage\StaticPage;
use App\Services\GeneratePdf;
use Maatwebsite\Excel\Facades\Excel;

class StaticPageController extends Controller
{
    public function index(Request $request)
    {
        $staticPages = StaticPage::search($request)
            ->ListsTranslations('name')
            ->CustomDateFromTo($request)
            ->with('translations')
            ->addSelect('static_pages.created_at', 'static_pages.is_active')
            ->sortBy($request)
            ->paginate((int)($request->per_page ?? config("globals.per_page")));


        return StaticPageResource::collection($staticPages)->additional([
            'status'=>true,
            'message'=>''
        ]);

    }

    public function store(StaticPageRequest $request, StaticPage $staticPage)
    {
        $staticPage->fill($request->validated() + ['added_by_id' => auth()->id()])->save();

        return StaticPageResource::make($staticPage)
            ->additional([
                'status'  => true,
                'message' => trans("dashboard.general.success_add")
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

        return StaticPageCollection::make($activities)->additional([
            'status' => true,
            'message' => ''
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

    public function destroy(StaticPage $staticPage)
    {
        if ($staticPage->link()->exists()) {
            return response()->json([
                'status' => false,
                'message' =>  trans("dashboard.static_page.validation.can_not_be_deleted_has_link"),
                'data' => null
            ], 422);
        }
        $staticPage->delete();

        return StaticPageResource::make($staticPage)->additional([
            'status' => true,
            'message' => trans('dashboard.general.success_delete'),
        ]);
    }

    public function getAllStaticPages(Request $request){
        $staticPages = StaticPage::where('is_active', true)->search($request)
        ->ListsTranslations('name')
        ->CustomDateFromTo($request)
        ->with('translations')
        ->addSelect('static_pages.created_at', 'static_pages.is_active')
        ->sortBy($request)->get();

    return StaticPageResource::collection($staticPages)->additional([
        'status'=>true,
        'message'=>''
    ]);
    }

    public function exportPDF(Request $request, GeneratePdf $pdfGenerate)
    {
        $StaticPagesQuery = StaticPage::search($request)
        ->ListsTranslations('name')
        ->CustomDateFromTo($request)
        ->addSelect(
            'static_pages.*'
        )
        ->sortBy($request)
        ->get();


        if (!$request->has('created_from')) {
            $createdFrom = StaticPage::selectRaw('MIN(created_at) as min_created_at')->value('min_created_at');
        }

        $mpdfPath = $pdfGenerate->newFile()
            ->view(
                'dashboard.exports.static_page',
                [
                    'static_pages' => $StaticPagesQuery,
                    'date_from'   => format_date($request->created_from) ?? format_date($createdFrom),
                    'date_to'     => format_date($request->created_to) ?? format_date(now()),
                    'userId'      => auth()->user()->login_id,

                ]
            )
            ->storeOnLocal('StaticPages/pdfs/');
        $file  = url('/storage/' . $mpdfPath);

        return response()->json([
            'data'   => [
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

        return response()->json([
            'data'   => [
                'file' => $file
            ],
            'status' => true,
            'message' => ''
        ]);
    }

}
