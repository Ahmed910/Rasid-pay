<?php

namespace App\Http\Controllers\Blade\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\AdminRequest;
use App\Http\Resources\Blade\Dashboard\Admin\AdminCollection;
use App\Http\Resources\Blade\Dashboard\Activitylog\ActivityLogCollection;
use App\Models\{Permission, User};
use App\Models\Department\Department;
use App\Models\Group\Group;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if (isset($request->order[0]['column'])) {
            $request['sort'] = ['column' => $request['columns'][$request['order'][0]['column']]['name'], 'dir' => $request['order'][0]['dir']];
        }

        if ($request->ajax()) {

            $adminsQuery = User::CustomDateFromTo($request)->search($request)->with(['department', 'permissions', 'groups' => function ($q) {
                $q->with('permissions');
            }])->where('user_type', 'admin')
                ->sortBy($request);

            $adminCount = $adminsQuery->count();
            $admins = $adminsQuery->skip($request->start)
                ->take(($request->length == -1) ? $adminCount : $request->length)
                ->get();
            return AdminCollection::make($admins)
                ->additional(['total_count' => $adminCount]);
        }


        $departments = Department::where('is_active', 1)
            ->select("id")
            ->ListsTranslations("name")
            ->pluck('name', 'id')->toArray();

        return view('dashboard.admin.index', compact('departments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $previousUrl = url()->previous();
        (strpos($previousUrl, 'admin')) ? session(['perviousPage' => 'admin']) : session(['perviousPage' => 'home']);

        $departments = Department::with('parent.translations')->ListsTranslations('name')->pluck('name', 'id')->toArray();
        $groups = Group::ListsTranslations('name')->pluck('name', 'id');
        $locales = config('translatable.locales');
        return view('dashboard.admin.create', compact('departments', 'locales', 'groups'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminRequest $request, User $admin)
    {
        $admin->fill($request->validated())->save();

        return redirect()->route('dashboard.admin.index')->withSuccess(__('dashboard.general.success_add'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show(Request $request, $id)
    {


        $admin = User::withTrashed()->where('user_type', 'admin')->findOrFail($id);


        $sortingColumns = [
            'id',
            'user_name',
            'department_name',
            'created_at',
            'action_type',
            'reason'
        ];
        if (isset($request->order[0]['column'])) {
            $request['sort'] = ['column' => $sortingColumns[$request->order[0]['column']], 'dir' => $request->order[0]['dir']];
        }

        $activitiesQuery  = $admin->activity()

            ->sortBy($request);

        if ($request->ajax()) {
            $activityCount = $activitiesQuery->count();
            $activities = $activitiesQuery->skip($request->start)
                ->take(($request->length == -1) ? $activityCount : $request->length)
                ->get();

            return ActivityLogCollection::make($activities)
                ->additional(['total_count' => $activityCount]);
        }
        return view('dashboard.admin.show', compact('admin'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $previousUrl = url()->previous();
        (strpos($previousUrl, 'admin')) ? session(['perviousPage' => 'admin']) : session(['perviousPage' => 'home']);
        $admin = User::where('user_type', 'admin')->findOrFail($id);
        $departments = Department::with('parent.translations')->ListsTranslations('name')->pluck('name', 'id')->toArray();
        $groups = Group::ListsTranslations('name')->pluck('name', 'id');
        $locales = config('translatable.locales');
        return view('dashboard.admin.edit',compact('admin','departments','groups','locales'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminRequest $request, User $admin)
    {
        $admin->fill($request->validated() + ['updated_at' => now()])->save();

        return redirect()->route('dashboard.admin.index')->withSuccess(__('dashboard.general.success_update'));
    }


    /**
     * get Employees by departmentId
     */
    public function getEmployeesByDepartment($id)
    {
        return response()->json([
            'data' => User::select('id', 'fullname')->where('user_type', 'employee')->whereHas('department', function ($q) use ($id) {
                $q->where('departments.id', $id);
            })->setEagerLoads([])->get(),
            'status' => true,
            'message' => '',
        ]);
    }
}
