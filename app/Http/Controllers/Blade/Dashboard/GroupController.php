<?php

namespace App\Http\Controllers\Blade\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Dashboard\GroupRequest;
use App\Http\Resources\Blade\Dashboard\Activitylog\ActivityLogCollection;
use App\Models\{Group\Group, Permission};
use Illuminate\Http\Request;
use App\Http\Resources\Blade\Dashboard\Group\GroupCollection;

class GroupController extends Controller
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

        $query = Group::with('groups', 'permissions')
            ->withTranslation()
            ->withCount('admins as user_count')
            ->search($request)
            ->sortBy($request);
        if (request()->ajax()) {
            $group_count = $query->count();
            $groups = $query->skip($request->start)
                ->take(($request->length == -1) ? $group_count : $request->length)
                ->get();
            return GroupCollection::make($groups)
                ->additional(['total_count' => $group_count]);
        }
        return view('dashboard.group.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $previousUrl = url()->previous();
        (strpos($previousUrl, 'group')) ? session(['perviousPage' => 'group']) : session(['perviousPage' => 'home']);

        $groups = Group::with('translations')
            ->ListsTranslations('name')->pluck('name', 'id');
        $permissions = Permission::permissions()->pluck('name', 'id');
        $locales = config('translatable.locales');

        return view('dashboard.group.create', compact('groups', 'permissions', 'locales'));
    }

    public function store(GroupRequest $request, Group $group)
    {
        $group->fill($request->validated() + ['added_by_id' => auth()->id()])->save();
        $permissions = $request->permission_list ?? [];
        if ($request->group_list) {
            $group->groups()->sync($request->group_list);
            $permissions = array_filter(array_merge($permissions, Group::find($request->group_list)->pluck('permissions')->flatten()->pluck('id')->toArray()));
        }
        $group->permissions()->sync($permissions);

        return redirect(route('dashboard.group.index'))->withTrue(trans('dashboard.messages.success_add'));
    }

    public function show(Group $group, Request $request)
    {
        if (isset($request->order[0]['column'])) {
            $request['sort'] = ['column' => $request['columns'][$request['order'][0]['column']]['name'], 'dir' => $request->order[0]['dir']];
        }

        $activitiesQuery  = $group->activity()
            ->sortBy($request);

        if ($request->ajax()) {
            $activityCount = $activitiesQuery->count();
            $activities = $activitiesQuery->skip($request->start)
                ->take(($request->length == -1) ? $activityCount : $request->length)
                ->get();

            return ActivityLogCollection::make($activities)
                ->additional(['total_count' => $activityCount]);
        }

        $group->withCount('admins')
            ->with([
                'translations', 'permissions', 'addedBy',
                'groups' => function ($q) {
                    $q->with('permissions');
                }
            ]);

        $groupsData  = Group::getGroupPermissions($group);

        if (!request()->ajax()) {
            return view('dashboard.group.show', compact('group', 'groupsData'));
        }
    }

    public function edit($id)
    {
        if (!request()->ajax()) {
            $locales = config('translatable.locales');
            $group = Group::where('id', "<>", auth()->user()->group_id)->findOrFail($id);
            $uris = Permission::permissions();

            return view('dashboard.group.edit', compact('group', 'uris','locales'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function update(GroupRequest $request, $id)
    {
        if (!request()->ajax()) {
            $group = Group::where('id', "<>", auth()->user()->group_id)->findOrFail($id);
            $group->fill($request->validated())->save();
            $permissions = $request->permission_list ?? [];
            if ($request->group_list) {
                $permissions = array_filter(array_merge($permissions, Group::find($request->group_list)->pluck('permissions')->flatten()->pluck('id')->toArray()));
            }
            $group->groups()->sync($request->group_list);
            $group->permissions()->sync($permissions);

            return redirect(route('dashboard.group.index'))->withTrue(trans('dashboard.messages.success_update'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function destroy(Group $group)
    {
        if ($group->delete()) {
            return response()->json(['value' => 1]);
        }
    }
}
