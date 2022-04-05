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
        $message = trans('dashboard.general.u_can_use_this_name');
        if (in_array($request->type,['department','job','permission'])) {
            foreach (config('translatable.locales') as $locale) {
                switch ($request->type) {
                    case 'department':
                    $rules += $this->validateDepartment($request,$locale);
                    break;
                    case 'job':
                    $rules += $this->validateJob($request,$locale);
                    break;
                    case 'permission':
                    $rules += $this->validatePermission($request,$locale);
                    break;
                }
            }
        }
        if ($request->type == 'admin') {
            $rules += $this->validateAdmin($request);
            $message = trans('dashboard.admin.u_can_use_this_id');
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
            'message' => $message,
        ], 200);
    }

    public function validateDepartment($request,$locale)
    {
        $rules["$locale.name"]  = "unique:department_translations,name," . ($request->department_id ?? 0)  . ",department_id";
        return $rules;
    }

    public function validateJob($request,$locale)
    {
        $rules["$locale.name"] = [function ($attribute, $value, $fail) use ($locale, $request) {
            $job = RasidJob::whereTranslation('name', $value, $locale)
                ->where('department_id', $request->department_id)
                ->when($request->rasid_job_id, function ($q) use ($request) {
                    $q->where('rasid_jobs.id', "<>", $request->rasid_job_id);
                })
                ->count();

            if ($job) {
                $fail(trans('dashboard.error.name_must_be_unique_on_department'));
            }
        }];
        return $rules;
    }

    public function validatePermission($request,$locale)
    {
        $rules["$locale.name"] = 'unique:group_translations,name,' . $request->group_id . ',group_id';
        return $rules;
    }

    public function validateAdmin($request)
    {
        $rules['login_id'] = 'required|digits:6|numeric|unique:users,login_id,' . $request->admin_id;
        return $rules;
    }
}
