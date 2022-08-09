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
        if (in_array($request->type, ['department', 'job', 'permission', 'static_page', 'transfer_purpose', 'bank'])) {
            foreach (config('translatable.locales') as $locale) {
                switch ($request->type) {
                    case 'department':
                        $rules += $this->validateDepartment($request, $locale);
                        break;
                    case 'job':
                        $rules += $this->validateJob($request, $locale);
                        break;
                    case 'permission':
                        $rules += $this->validatePermission($request, $locale);
                        break;
                    case 'static_page':
                        $rules += $this->validateStaticPage($request, $locale);
                        break;
                    case 'transfer_purpose':
                        $rules += $this->validateTransferPurpose($request, $locale);
                        break;
                    case 'bank':
                        $rules += $this->validateBank($request, $locale);
                        break;
                }
            }
        }
        if ($request->type == 'admin') {
            $rules += $this->validateAdmin($request);
            $message = trans('dashboard.admin.u_can_use_this_id');
        }

        if ($request->type == 'vendor_phone') {
            $rules += $this->validateVendorPhone($request);
            $message = trans('dashboard.vendor.u_can_not_use_this_phone');
        }

        if ($request->type == 'admin_email') {
            $rules += $this->validateAdminEmail($request);
            $message = trans('dashboard.admin.u_can_not_use_this_email');
        }

        if ($request->type == 'admin_phone') {
            $rules += $this->validateAdminPhone($request);
            $message = trans('dashboard.admin.u_can_not_use_this_phone');
        }

        if ($request->type == 'permission') {
            $rules["$locale.name"] = 'unique:group_translations,name,' . @$request->group_id . ',group_id';
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

    public function validateDepartment($request, $locale)
    {
        $rules["$locale.name"]  = "unique:department_translations,name," . ($request->department_id ?? 0)  . ",department_id";
        return $rules;
    }

    public function validateJob($request, $locale)
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

    public function validatePermission($request, $locale)
    {
        $rules["$locale.name"] = 'unique:group_translations,name,' . ($request->group_id ?? 0) . ',group_id';
        return $rules;
    }

    public function validateAdmin($request)
    {
        $rules['login_id'] = 'required|digits:6|numeric|unique:users,login_id,' . $request->admin_id;
        return $rules;
    }
    public function validateAdminEmail($request)
    {
        $rules['email'] = 'unique:users,email,' . $request->admin_id;
        return $rules;
    }

    public function validateAdminPhone($request)
    {
        $rules['phone'] = 'unique:users,phone,' . $request->admin_id;
        return $rules;
    }

    public function validateStaticPage($request, $locale)
    {
        $rules["$locale.name"] = "unique:static_page_translations,name," . ($request->static_page_id ?? 0) . ',static_page_id';
        return $rules;
    }
    public function validateTransferPurpose($request, $locale)
    {
        $rules["$locale.name"] = "unique:transfer_purpose_translations,name," . ($request->transfer_purpose_id ?? 0) . ',transfer_purpose_id';
        return $rules;
    }

    public function validateBank($request, $locale)
    {
        $rules["$locale.name"] = "unique:bank_translations,name," . ($request->bank_id ?? 0) . ',bank_id';
        return $rules;
    }

    public function validateVendorPhone($request)
    {
        $request->phone = filter_mobile_number($request->phone);
        $rules['phone'] = 'unique:vendors,phone,' . $request->vendor_id;
        return $rules;
    }
}
