<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Dashboard\LocalizationRequest;
use App\Http\Resources\Dashboard\TranslationResource;
use App\Models\Locale\Locale;
use App\Models\Locale\LocaleTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;

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
}
