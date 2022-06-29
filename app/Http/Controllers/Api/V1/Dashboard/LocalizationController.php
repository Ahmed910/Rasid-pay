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
        $locale = $request->local ?? app()->getLocale();

        return response()->json(
            Arr::undot(\App\Models\Locale\Locale::join('locale_translations', 'locale_translations.locale_id', '=', 'locales.id')
                ->when($locale != null, fn ($q) => $q->where('locale', $locale))
                ->where('file', 'vue_static')
                ->pluck('value', 'key'))
        );
    }

    public function store(Request $request, Locale $locale, LocaleTranslation $localeTranslation)
    {
        $rules = [
            "local" => "required|in:en,ar"
        ];
        $requestlocale = $request->local;
        $rules["$requestlocale"] = "array";
        $rules["$requestlocale.value"] = "required|between:1,255";
        $rules["$requestlocale.desc"] = "nullable|string|max:300";
        $this->validate($request, $rules);

        $locale->fill(["key" => $request->key, "file" => "vue_static"])->save();
        $data = $request->only(["value", "desc"]);

        $trans = $localeTranslation->fill(
            [
                "locale" => $requestlocale,
                "desc" => @$request[$requestlocale]["desc"],
                "value" => $request[$requestlocale]["value"]
            ]
        );
        $locale->translations()->save($trans);
        return response()->json([
            'status' => true,
            'message' => __('dashboard.general.success_add')
        ]);
    }

    public function update($id, LocalizationRequest $request)
    {
        $locale = $request->local;
        $trans = Locale::wherehas('translations', function ($q) use ($request) {
            $q->where("locale", $request->local);
        })->findorfail($id);
        $data = $request->only(["value", "desc",]);
        $trans->translations()->where("locale", $request->local)->update(
            [
                "desc" => @$request[$locale]["desc"],
                "value" => $request[$locale]["value"]
            ]
        );
        if ($trans->wasChanged()) {
            Cache::forget("translations_" . app()->getLocale());
        }
        return response()->json([
            'status' => true,
            'message' => __('dashboard.general.success_update')
        ]);
    }
}
