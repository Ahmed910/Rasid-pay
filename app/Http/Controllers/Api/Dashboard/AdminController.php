<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Exports\AdminsExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\AdminRequest;
use App\Http\Requests\Dashboard\ReasonRequest;
use App\Http\Resources\Api\Dashboard\{UserResource, Admin\AdminCollection};
use App\Http\Resources\Api\Dashboard\Admin\AllAdminResource;
use App\Models\{ActivityLog, Admin, User, Permission, Group\Group, Employee};
use App\Models\Department\Department;
use Illuminate\Http\Request;
use App\Services\GeneratePdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Traits\Loggable;
class AdminController extends Controller
{

    public function index(Request $request)
    {
        request()->user_type = "admin";
        $users = User::customDateFromTo($request)
            ->has('employee')
            ->search($request)
            ->with(['department', 'permissions', 'groups' => function ($q) {
                $q->with('permissions');
            }])->where('user_type', 'admin')
            ->sortBy($request)
            ->paginate((int)($request->per_page ?? config("globals.per_page")));

        return UserResource::collection($users)
            ->additional([
                'status' => true,
                'message' => '',
                'departments' => Department::ListsTranslations('name')->without(['images', 'addedBy'])->get()
            ]);
    }

    public function archive(Request $request)
    {
        $users = User::onlyTrashed()->where('user_type', 'admin')->latest()->paginate((int)($request->per_page ?? config("globals.per_page")));
        return UserResource::collection($users)
            ->additional([
                'status' => true,
                'message' => ''
            ]);
    }

    public function create(Request $request)
    {
        $users = User::with(['department', 'permissions', 'groups' => function ($q) {
            $q->with('permissions');
        }])->where('user_type', 'employee')->latest()->get();

        return UserResource::collection($users)
            ->additional([
                'status' => true,
                'message' => '',
            ]);
    }


    public function store(AdminRequest $request, User $admin)
    {
        $admin->fill([
            'user_type' => 'admin', 'added_by_id' => auth()->id(),
        ] + $request->validated())->save();
        $employee = Employee::create($request->safe()->only(['department_id', 'rasid_job_id']) + ['user_id' => $admin->id]);
        $employee->job()->update(['is_vacant' => 0]);
        $admin->admin()->create();
        //TODO::send sms with password
        $permissions = Permission::setPermissions($request);
        if ($request->group_list) {
            $admin->groups()->sync($request->group_list);
            $permissions = array_merge($permissions, Group::find($request->group_list)->pluck('permissions')->flatten()->pluck('id')->toArray());
        }
        $admin->permissions()->sync(array_filter($permissions));
        return UserResource::make($admin)
            ->additional([
                'status' => true,
                'message' => __('dashboard.general.success_add'),
            ]);
    }

    public function show(Request $request, $id)
    {
        $admin = User::withTrashed()->where('user_type', 'admin')->with('admin')->findOrFail($id);
        $activities = [];
        if ((!$request->has('with_activity') || $request->with_activity) && $request->routeIs('*.show')) {
            $activities = $admin->activity()
                ->sortBy($request)
                ->paginate((int)($request->per_page ??  config("globals.per_page")));
        }

        return AdminCollection::make($activities)
            ->additional([
                'status' => true,
                'message' => ''
            ]);
    }

    public function update(AdminRequest $request, User $admin)
    {
        if ($request->ban_status != 'active' && $admin->messageTypes()->exists()) {
            return response()->json(['data'   => null, 'message' => trans('validation.admin.cant_deactive_admin_while_he_has_message_types'), 'status' => false], 422);
        }
        if ($request->password_change && $request->password_change == 1) {
            $admin->fill($request->validated() + ['updated_at' => now()])->save();
        } else {
            $admin->fill($request->safe()->except(['password']) + ['updated_at' => now()])->save();
        };
        $admin->admin()->updateOrCreate(['user_id' => $admin->id], $request->only(['ban_status', 'ban_from', 'ban_to']) + ['updated_at' => now()]);
        $admin->employee->update($request->safe()->only(['department_id', 'rasid_job_id']));
        $admin->employee->job()->update(['is_vacant' => 0]);

        //TODO::send sms with password
        // if($request->('password_change'))
        $permissions = Permission::setPermissions($request);
        if ($request->group_list) {
            $admin->groups()->sync($request->group_list);
            $permissions = array_merge($permissions, Group::find($request->group_list)->pluck('permissions')->flatten()->pluck('id')->toArray());
        } elseif (!$request->group_list && $admin->groups()->exists()) {
            $admin->groups()->detach();
        }

        $admin->permissions()->sync(array_filter($permissions));

        return UserResource::make($admin)
            ->additional([
                'status' => true,
                'message' => __('dashboard.general.success_update'),
            ]);
    }

    //archive data
    // public function destroy(ReasonRequest $request, $admin)
    // {
    //     $admin = User::where('user_type', 'admin')->findOrFail($admin);
    //     $admin->delete();
    //     return UserResource::make($admin)
    //         ->additional([
    //             'status' => true,
    //             'message' =>  __('dashboard.general.success_archive'),
    //         ]);
    // }

    //restore data from archive
    // public function restore(ReasonRequest $request, $id)
    // {
    //     $admin = User::onlyTrashed()->where('user_type', 'admin')->findOrFail($id);
    //     $admin->restore();

    //     return UserResource::make($admin)
    //         ->additional([
    //             'status' => true,
    //             'message' =>  __('dashboard.general.success_restore'),
    //         ]);
    // }

    //force delete data from archive
    // public function forceDelete(ReasonRequest $request, $id)
    // {
    //     $admin = User::onlyTrashed()->where('user_type', 'admin')->findOrFail($id);
    //     $admin->forceDelete();

    //     return UserResource::make($admin)
    //         ->additional([
    //             'status' => true,
    //             'message' =>  __('dashboard.general.success_delete'),
    //         ]);
    // }

    public function getAllAdmins(Request $request)
    {

        $users = User::where('user_type', 'admin')
            ->when($request->has_permission_on && is_array($request->has_permission_on), function ($q) use ($request) {
                $q->whereHas('permissions', function ($q) use ($request) {
                    $q->whereIn('main_program', $request->has_permission_on);
                })->where('users.id', '!=', auth()->id());
            })->when($request->ban_status, function ($q) use ($request) {
                $q->where('ban_status', $request->ban_status);
            })
            ->get();

        return AllAdminResource::collection($users)
            ->additional([
                'status' => true,
                'message' => '',

            ]);
    }


    public function exportPDF(Request $request, GeneratePdf $generatePdf)
    {
        $AdminsQuery = User::customDateFromTo($request)
            ->has('employee')
            ->search($request)
            ->with(['department', 'permissions', 'groups' => function ($q) {
                $q->with('permissions');
            }])->where('user_type', 'admin')
            ->sortBy($request)
            ->get();

        Loggable::addGlobalActivity(User::class, array_merge($request->query(),
        ['department_id' => Department::find($request->department_id)?->name]),
         ActivityLog::EXPORT, 'index', request()->user_type);

        if (!$request->has('created_from')) {
            $createdFrom = User::selectRaw('MIN(created_at) as min_created_at')->value('min_created_at');
        }

        $chunk = 200;
        $names = [];
        foreach (($AdminsQuery->chunk($chunk)) as $key => $rows) {
            $names[] =  base_path('storage/app/public/') . $generatePdf->newFile()
                ->setHeader(trans('dashboard.admin.admins'), $createdFrom)
                ->view('dashboard.exports.admin', $rows, $key, $chunk)
                ->storeOnLocal('admins/pdfs/');
        }

        $file = GeneratePdf::mergePdfFiles($names, 'admins/pdfs/admins.pdf');

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
        Excel::store(new AdminsExport($request), 'Admins/excels/' . $fileName . '.xlsx', 'public');
        $file = url('/storage/' . 'Admins/excels/' . $fileName . '.xlsx');

         Loggable::addGlobalActivity(User::class, array_merge($request->query(),
        ['department_id' => Department::find($request->department_id)?->name]),
         ActivityLog::EXPORT, 'index', request()->user_type);

        return response()->json([
            'data'   => [
                'file' => $file
            ],
            'status' => true,
            'message' => ''
        ]);
    }
}
