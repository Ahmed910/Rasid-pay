<?php

namespace App\Http\Controllers\Blade\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Dashboard\AdminRequest;
use App\Http\Resources\Blade\Dashboard\Admin\AdminCollection;
use App\Models\{User};
use App\Models\Department\Department;
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

        $adminsQuery = User::CustomDateFromTo($request)->search($request)->with(['department', 'permissions', 'groups' => function ($q) {
            $q->with('permissions');
        }])->where('user_type', 'admin')

            ->sortBy($request);



        if ($request->ajax()) {
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
            ->pluck('name', 'id');

        return view('dashboard.admin.index', compact('departments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.admin.create');
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
    public function show($id)
    {
        return view('dashboard.admin.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('dashboard.admin.edit');
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $admin)
    {
    }
}
