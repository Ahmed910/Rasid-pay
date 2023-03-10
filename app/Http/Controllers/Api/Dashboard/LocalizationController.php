<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Exports\LocaleExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\LocalizationRequest;
use App\Http\Resources\Api\Dashboard\TranslationResource;
use App\Models\ActivityLog;
use App\Models\Locale\Locale;
use App\Models\Locale\LocaleTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use App\Services\GeneratePdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Traits\Loggable;
class LocalizationController extends Controller
{
    public function index(Request $request)
    {
        $translations = Locale::query()
            ->ListsTranslations('value')
            ->where('file', 'vue_static')
            ->addSelect('locale_id', 'key', 'value', 'locale', 'desc')
            ->search($request)
            ->sortBy($request)
            ->paginate((int)($request->per_page ?? config("globals.per_page")));

        return TranslationResource::collection($translations)
            ->additional([
                'status' => true,
                'message' => "",
            ]);
    }

    public function updateTranslation(LocalizationRequest $request)
    {
        $localeTranslation = LocaleTranslation::findOrFail($request->id);
        $localeTranslation->fill($request->validated())->save();

        if ($localeTranslation->wasChanged()) {
            Cache::forget("translations_" . app()->getLocale());
        }

        return response()->json([
            'status' => true,
            'message' => __('dashboard.general.success_update')
        ]);
    }

    public function getAllTranslations(Request $request)
    {
        $locale = $request->local ?? app()->getLocale();

        return response()->json(
            Arr::undot(\App\Models\Locale\Locale::join('locale_translations', 'locale_translations.locale_id', '=', 'locales.id')
                ->when($locale != null, fn ($q) => $q->where('locale', $locale))
                ->where('file', 'vue_static')
                ->pluck('value', 'key'))
        );
    }

    public function store(Request $request)
    {
        $rules = [
            'key'                   => 'required',
            'translations'          => 'array|required',
            'translations.*.value'  => 'required|between:1,255',
            'translations.*.desc'   => 'nullable|string|max:300',
        ];
        $this->validate($request, $rules);
        $locale = Locale::create([
            "key" => $request->key,
            "file" => $request->file ?? "vue_static"
        ]);

        foreach ($request->translations as $lang => $trans) {
            LocaleTranslation::create([
                'locale_id' => $locale->id,
                'locale'    => $lang,
                'value'     => $trans['value'],
                'desc'      => $trans['desc'] ?? null
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => __('dashboard.general.success_add')
        ]);
    }
    public function exportPDF(Request $request, GeneratePdf $generatePdf)
    {
        $localsQuery = Locale::query()
        ->ListsTranslations('value')
        ->where('file', 'vue_static')
        ->addSelect('locale_id', 'key', 'value', 'locale', 'desc')
        ->search($request)
        ->sortBy($request)
        ->get();

        Loggable::addGlobalActivity(Locale::class, $request->query(), ActivityLog::EXPORT, 'index');

        if (!$request->has('created_from')) {
            $createdFrom = Locale::selectRaw('MIN(created_at) as min_created_at')->whereNotNull('created_at')->value('min_created_at');
        }

        $chunk = 200;
        $names = [];
        if (!$localsQuery->count()) {
            $file = GeneratePdf::createNewFile(
                trans('dashboard.localization.localizations'),
                $createdFrom,'dashboard.exports.locale',
                $localsQuery,0,$chunk,'localizations/pdfs/'
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
        foreach (($localsQuery->chunk($chunk)) as $key => $rows) {
            $names[] = GeneratePdf::createNewFile(
                trans('dashboard.localization.localizations'),$createdFrom,
                'dashboard.exports.locale',
                $rows,$key,$chunk,'locals/pdfs/'
            );
        }
        $file = GeneratePdf::mergePdfFiles($names, 'locals/pdfs/locals.pdf');

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
        Excel::store(new LocaleExport($request), 'locals/excels/' . $fileName . '.xlsx', 'public');
        $file = url('/storage/' . 'locals/excels/' . $fileName . '.xlsx');
        Loggable::addGlobalActivity(Locale::class, $request->query(), ActivityLog::EXPORT, 'index');

        return response()->json([
            'data'   => [
                'file' => $file
            ],
            'status' => true,
            'message' => ''
        ]);
    }
}
