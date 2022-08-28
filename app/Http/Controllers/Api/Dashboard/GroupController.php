<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Exports\GroupsExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\GroupRequest;
use App\Http\Resources\Api\Dashboard\Group\{GroupResource, GroupCollection, PermissionResource, UriResource};
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\{ActivityLog, Group\Group, Permission};
use App\Services\GeneratePdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Traits\Loggable;
class GroupController extends Controller
{

    public function index(Request $request)
    {
        $groups = Group::with('groups', 'permissions')
            ->withTranslation()
            ->search($request)
            ->sortBy($request)
            ->paginate((int)($request->per_page ??  config("globals.per_page")));

        return GroupResource::collection($groups)->additional(['status' => true, 'message' => ""]);
    }

    public function store(GroupRequest $request, Group $group)
    {

        $group->fill($request->validated() + ['added_by_id' => auth()->id()])->save();
        $permissions = Permission::setPermissions($request);
        if ($request->group_list) {
            $group->groups()->sync($request->group_list);
            $permissions = array_merge($permissions, Group::find($request->group_list)->pluck('permissions')->flatten()->pluck('id')->toArray());
        }
        $group->permissions()->sync(array_filter($permissions));
        return GroupResource::make($group)->additional(['status' => true, 'message' => trans('dashboard.general.success_add')]);
    }

    public function show(Request $request, $id)
    {
        $group = Group::findOrFail($id);
        $activities = [];
        if ((!$request->has('with_activity') || $request->with_activity) && $request->routeIs('*.show')) {
            $activities  = $group->activity()
                ->sortBy($request)
                ->paginate((int)($request->per_page ??  config("globals.per_page")));
        }
        return GroupCollection::make($activities)
            ->additional([
                'status' => true,
                'message' => ''
            ]);
    }

    public function checkIfUserHasPermission(Request $request, $route_name)
    {
        $has_access = auth()->user()->hasPermissions($route_name);
        return response()->json([
            'data' => null,
            'status' => $has_access,
            'message' => ''
        ], $has_access ? 200 : 403);
    }

    public function getPermissionsOfGroup(Group $group, Request $request)
    {
        $permissions = $group->permissions()->where('is_active',true)
            ->sortBy($request)->paginate((int)($request->per_page ??  config("globals.per_page")));

        return PermissionResource::collection($permissions)
            ->additional([
                'status' => true,
                'message' => ''
            ]);
    }

    public function update(GroupRequest $request, Group $group)
    {
        $old_permissions = $group->permission_list;
        $group->fill($request->validated() + ['updated_at' => now()])->save();
        $permissions = Permission::setPermissions($request);
        if ($request->group_list) {
            $permissions = array_merge($permissions, Group::find($request->group_list)->pluck('permissions')->flatten()->pluck('id')->toArray());
        }

        $shared_permissions = array_intersect($old_permissions, $permissions);
        $attached_permissions = array_diff($permissions, $shared_permissions);
        $detached_permissions = array_diff($old_permissions, $shared_permissions);
        if ($attached_permissions || $detached_permissions) {
            $group->admins?->each(function ($admin) use ($attached_permissions, $detached_permissions) {
                if ($detached_permissions) {
                    $admin->permissions()->detach($detached_permissions);
                }
                $new_permissions = array_diff($attached_permissions, $admin->permission_list);
                if ($new_permissions) {
                    $admin->permissions()->syncWithoutDetaching($new_permissions);
                }
            });
        }

        $group->groups()->sync($request->group_list);

        if(!$request->group_list && $group->groups()->exists()){
            $group->groups()->detach();
        }

        if($request->is_active == 0 && $group->groups()->exists()){
            $group->groups()->getQuery()->update(['is_active' => 0]);
        }

        $group->permissions()->sync(array_filter($permissions));
        return GroupResource::make($group)->additional(['status' => true, 'message' => trans('dashboard.general.success_update')]);
    }


    public function destroy(Group $group)
    {
        $group->delete();
        $group->admins?->each(function ($user) {
            $user->permissions()->detach();
        });
        return GroupResource::make($group)->additional(['status' => true, 'message' => trans('dashboard.general.success_delete')]);
    }

    public function permissions(Request $request)
    {
        return UriResource::collection(Permission::getPermissions())->additional(['status' => true, 'message' => '']);
    }

    public function getGroups(Request $request, $group_id = null)
    {
        $groups = Group::when($group_id, function ($q) use ($group_id) {
            $q->where('groups.id', "<>", $group_id);
        })->when($request->activate_case, function ($q) use ($request) {
            switch ($request->activate_case) {
                case 'active':
                    $q->where('is_active', 1);
                    break;
                case 'hold':
                    $q->where('is_active', 0);
                    break;
            }
        })->with('permissions')->ListsTranslations('name')->without(['addedBy'])->get();

        return GroupResource::collection($groups)->additional(['status' => true, 'message' => ""]);
    }

    public function exportPDF(Request $request, GeneratePdf $generatePdf)
    {
        $groupsQuery = Group::with('groups', 'permissions')
        ->withTranslation()
        ->withCount('admins as user_count')
        ->search($request)
        ->sortBy($request)
        ->get();

        Loggable::addGlobalActivity(Group::class, $request->query(), ActivityLog::EXPORT, 'index');

        if (!$request->has('created_from')) {
            $createdFrom = Group::selectRaw('MIN(created_at) as min_created_at')->value('min_created_at');
        }

        $chunk = 200;
        $names = [];
        if (!$groupsQuery->count()) {
            $file = GeneratePdf::createNewFile(
                trans('dashboard.group.all_groups'),
                $createdFrom,'dashboard.exports.group',
                $groupsQuery,0,$chunk,'groups/pdfs/'
            );
            $file =  url(str_replace(base_path('storage/app/public/'), 'storage/', $file));
            return response()->json([
                'data'   => [
                    'file' => $file
                ],
                'status' => true,
                'message' => ''
            ]);
        }
        foreach (($groupsQuery->chunk($chunk)) as $key => $rows) {
            $names[] = GeneratePdf::createNewFile(
                trans('dashboard.group.all_groups'),$createdFrom,
                'dashboard.exports.group',
                $rows,$key,$chunk,'groups/pdfs/'
            );
        }

        $file = GeneratePdf::mergePdfFiles($names, 'groups/pdfs/groups.pdf');

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
        Excel::store(new GroupsExport($request), 'groups/excels/' . $fileName . '.xlsx', 'public');
        $file = url('/storage/' . 'groups/excels/' . $fileName . '.xlsx');
        Loggable::addGlobalActivity(Group::class, $request->query(), ActivityLog::EXPORT, 'index');

        return response()->json([
            'data'   => [
                'file' => $file
            ],
            'status' => true,
            'message' => ''
        ]);
    }
}
