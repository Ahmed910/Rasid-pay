<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\RasidJob\RasidJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ValidateController extends Controller
{
    public function __invoke(Request $request)
    {
        $rules = [];

        foreach (config('translatable.locales') as $locale) {
            if ($request->type == 'department') {
                $rules["$locale.name"]  = "unique:department_translations,name," . ($request->department_id ?? 0)  . ",department_id";
            }

            if ($request->type == 'job') {
                $rules["$locale.name"] = [function ($attribute, $value, $fail) use ($locale, $request) {
                    $job = RasidJob::whereTranslation('name', $value, $locale)
                        ->where('department_id', $request->department_id)
                        ->when($request->rasid_job_id, function ($q, $request) {
                            $q->where('rasid_jobs.id', "<>", $request->rasid_job_id);
                        })
                        ->count();

                    if ($job) {
                        $fail(trans('dashboard.error.name_must_be_unique_on_department'));
                    }
                }];
            }
        }

        $validator = Validator::make(
            $request->all(),
            $rules
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => trans('dashboard.error.something_went_wrong'),
                'errors' => $validator->errors()->toArray(),
                'data' => null,
            ], 422);
        }

        return response()->json([
            'status' => true,
            'data' => null,
            'message' => '',
        ], 200);
    }
}
