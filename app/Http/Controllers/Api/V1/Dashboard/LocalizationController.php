<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Dashboard\LocalizationRequest;
use App\Http\Resources\Dashboard\TranslationResource;
use App\Models\Locale\Locale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class LocalizationController extends Controller
{
    public function index(Request $request)
    {
        return TranslationResource::collection(db_translations($request->local, file: "vue_static"))
            ->additional([
                'status' => true,
                'message' => ''
            ]);
    }

    public function update($id, LocalizationRequest $request)
    {
        $trans = Locale::whereHas('translations', fn ($q) => $q->where("locale", $request->local))->findorfail($id);
        $trans->update($request->except(["Local"]));

        if ($trans->wasChanged()) {
            Cache::forget("translations_" . app()->getLocale());
        }

        return response()->json([
            'status' => true,
            'message' => __('dashboard.general.success_update')
        ]);
    }
}
