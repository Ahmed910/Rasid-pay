<?php

namespace App\Http\Controllers\Blade\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\{ Group\Group , Permission };
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Requests\Dashboard\Group\GroupRequest;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!request()->ajax()) {
          $groups = Group::where('id',"<>",auth()->user()->group_id)->latest()->paginate(100);
          return view('dashboard.group.index',compact('groups'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!request()->ajax()) {
            $uris = $this->permissions();
            return view('dashboard.group.create',compact('uris'));
        }
      }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GroupRequest $request,Group $group)
    {
        if (!request()->ajax()) {
            $group->fill($request->validated())->save();
            $group->permissions()->sync($request->permissions);

            return redirect(route('dashboard.group.index'))->withTrue(trans('dashboard.messages.success_add'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function show(Group $group)
    {
        if (!request()->ajax()) {
           return view('dashboard.group.show',compact('group'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!request()->ajax()) {
            $group = Group::where('id',"<>",auth()->user()->group_id)->findOrFail($id);
            $uris = $this->permissions();
            return view('dashboard.group.edit',compact('group','uris'));
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
            $group = Group::where('id',"<>",auth()->user()->group_id)->findOrFail($id);
            $group->fill($request->validated())->save();
            $group->permissions()->sync($request->permissions);

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

    private function permissions()
    {
        $permissions = Permission::where('permission_on', 'dashboard_blade')->get();
        foreach (app()->routes->getRoutes() as $value) {
            if(str_contains($value->getPrefix(),'dashboard') && !str_contains($value->getPrefix(),'api')){
                if($value->getName() != 'dashboard.' && !is_null($value->getName())){
                    $path = str_after($value->getName(),'.');
                    $uri = str_replace(['create','edit'],['store','update'],$path);
                    if (!$uri || ($permissions->contains('name',$uri) && $permissions->contains('permission_on','dashboard_blade')) || in_array($uri,Permission::PUBLIC_ROUTES)) {
                        continue;
                    }
                    $permissions->push(Permission::create(['name' => $uri,'permission_on' => 'dashboard_blade']));
                }
            }
        }
        $permissions->transform(function ($item) {
            $action = explode('.',$item->name);
            $data['uri'] = $action[0];
            $data['action'] = $action[1];
            $data['name'] = trans('dashboard.'.$action[0].'.permissions.'.$action[1]);
            $data['id'] = $item->id;
            return $data;
        });

        $permissions = $permissions->groupBy('uri')->map(function ($item,$key) {
            $data['program'] = trans('dashboard.'.$key.".".str_plural($key));
            $data['permissions'] = $item;
            return $data;
        });

        return $permissions;
    }
}
