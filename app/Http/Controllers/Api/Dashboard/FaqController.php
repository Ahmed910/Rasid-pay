<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Exports\FaqExport;
use App\Models\Faq\Faq;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\FaqRequest;
use App\Http\Resources\Api\Dashboard\Faq\FaqResource;
use App\Http\Resources\Api\Dashboard\Faq\FaqCollection;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use App\Services\GeneratePdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Traits\Loggable;
use App\Http\Requests\Dashboard\ReasonRequest;


class  FaqController extends Controller
{
    public function index(Request $request)
    {
        $faq = Faq::search($request)
            ->ListsTranslations('question')
            ->customDateFromTo($request)
            ->addSelect('faqs.*')
            ->sortBy($request)
            ->paginate((int)($request->per_page ?? config("globals.per_page")));

        return FaqResource::collection($faq)->additional([
            'status' => true,
            'message' => ''
        ]);
    }

    public function store(FaqRequest $request)
    {
        $faq = Faq::create($request->validated());

        return FaqResource::make($faq->refresh())->additional(['status' => true, 'message' => trans('dashboard.general.success_add')]);
    }


    public function update(FaqRequest $request, Faq $faq)
    {
        $faq->update($request->validated() + ['updated_at' => now()]);
        return FaqResource::make($faq->refresh())->additional(['status' => true, 'message' => trans('dashboard.general.success_update')]);
    }


    public function show(Request $request, $id)
    {
        $faq  = Faq::findOrFail($id);
        $activities = [];
        if ((!$request->has('with_activity') || $request->with_activity) && $request->routeIs('*.show')) {
            $activities  = $faq->activity()
                ->sortBy($request)
                ->paginate((int)($request->per_page ??  config("globals.per_page")));
        }

        return FaqCollection::make($activities)->additional([
            'status' => true,
            'message' => ''
        ]);
    }

    public function destroy(ReasonRequest $request,Faq $faq)
    {
        $faq->delete();
        return FaqResource::make($faq)
            ->additional([
                'status' => true,
                'message' =>  __('dashboard.general.success_delete')
            ]);
    }
    public function exportPDF(Request $request, GeneratePdf $generatePdf)
    {
        $faqsQuery = Faq::search($request)
            ->customDateFromTo($request)
            ->ListsTranslations('question')
            ->sortBy($request)
            ->addSelect('faqs.created_at', 'faqs.is_active', 'faqs.order')
            ->get();

        if (!$request->has('created_from')) {
            $createdFrom = Faq::selectRaw('MIN(created_at) as min_created_at')->value('min_created_at');
        }
        Loggable::addGlobalActivity(Faq::class, $request->query(), ActivityLog::EXPORT, 'index');

        $chunk = 200;
        $names = [];
        if (!$faqsQuery->count()) {
            $file = GeneratePdf::createNewFile(
                trans('dashboard.faq.faqs'),
                $createdFrom,'dashboard.exports.faq',
                $faqsQuery,0,$chunk,'faqs/pdfs/'
            );
            $file =  url(str_replace(base_path('storage/app/public/'), 'storage/', $file));
            return response()->json([
                'data'   => [
                    'file' => $file
                ],
                'status' => true,
                'message' => ''
            ]);
        }
        foreach (($faqsQuery->chunk($chunk)) as $key => $rows) {
            $names[] = GeneratePdf::createNewFile(
                trans('dashboard.faq.faqs'),$createdFrom,
                'dashboard.exports.faq',
                $rows,$key,$chunk,'faqs/pdfs/'
            );
        }

        $file = GeneratePdf::mergePdfFiles($names, 'faqs/pdfs/faqs.pdf');

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
        Excel::store(new FaqExport($request), 'faqs/excels/' . $fileName . '.xlsx', 'public');
        $file = url('/storage/' . 'faqs/excels/' . $fileName . '.xlsx');
        Loggable::addGlobalActivity(Faq::class, $request->query(), ActivityLog::EXPORT, 'index');

        return response()->json([
            'data'   => [
                'file' => $file
            ],
            'status' => true,
            'message' => ''
        ]);
    }
}
