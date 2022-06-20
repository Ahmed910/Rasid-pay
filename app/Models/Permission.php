<?php

namespace App\Models;

use App\Models\Group\Group;
use App\Traits\{Loggable, Uuid};
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Permission extends Model
{
    use HasFactory, Uuid, Loggable;
    #region properties
    protected $guarded = ["created_at", "updated_at"];
    const PUBLIC_ROUTES = [
        'notifications.index',
        'notifications.show',
        'notifications.destroy',
        'notifications.update',
        'profiles.show',
        'profiles.update',
        'profiles.change_password',
        'menus.index',
        'menus.store',
        'menus.update',
        'menus.show',
        'menus.destroy',
        'session.logout',
        "activity_logs.employees",
        "activity_logs.main_programs",
        "activity_logs.sub_programs",
        "activity_logs.events",
        "citizens.enabled_packages",
        "image_delete",
        "send_message",
        "validate",
        'group_permissions',
        'backButton',
        'home'
    ];

    private $sortableColumns = ['main_program', 'sub_program', 'name'];
    #endregion properties

    #region mutators
    public function setNameAttribute($value)
    {
        $permission = explode('.', $value);
        $this->attributes['main_program'] = $permission[0];
        $this->attributes['action'] = @$permission[1];
        $sub_prog = null;
        switch ($permission) {
            case in_array(@$permission[1], ['update', 'show', 'destroy']):
                $sub_prog = 'index';
                break;
            case in_array(@$permission[1], ['restore', 'force_delete']):
                $sub_prog = 'archive';
                break;
        }
        $this->attributes['sub_program'] = $sub_prog;
        $this->attributes['name'] = $value;
    }

    public function getActionTransAttribute()
    {
        return trans('dashboard.' . str_singular($this->attributes['main_program']) . ".permissions." . $this->attributes['action']);
    }

    public function getMainProgramTransAttribute()
    {
        return trans('dashboard.' . str_singular($this->attributes['main_program']) . "." . $this->attributes['main_program']);
    }

    public function getSubProgramTransAttribute()
    {
        if ($this->attributes['sub_program']) {
            return trans('dashboard.' . str_singular($this->attributes['main_program']) . '.sub_progs.' . $this->attributes['sub_program']);
        }
        return '---';
    }
    #endregion mutators

    #region scopes

    public function scopeBlade($query)
    {
        $query->where('permission_on', 'blade');
    }

    public function scopeSortBy(Builder $query, $request)
    {
        if (!isset($request->sort["column"]) || !isset($request->sort["dir"])) return $query->latest('created_at');

        if (
            !in_array(Str::lower($request->sort["column"]), $this->sortableColumns) ||
            !in_array(Str::lower($request->sort["dir"]), ["asc", "desc"])
        ) {
            return $query->latest('created_at');
        }


        $query->when($request->sort, function ($q) use ($request) {
            if ($request->sort["column"]  == "main_program") {
                return $q->orderBy('main_program', @$request->sort["dir"]);
            }

            if ($request->sort["column"]  == "sub_program") {
                return $q->orderBy('sub_program', @$request->sort["dir"]);
            }

            $q->orderBy($request->sort["column"], @$request->sort["dir"]);
        });
    }
    #endregion scopes

    #region relationships
    public function groups()
    {
        return $this->belongsToMany(Group::class);
    }
    #endregion relationships

    #region custom Methods
    public static function getPermissions()
    {
        $permissions = Permission::latest()->get();
        foreach (app()->routes->getRoutes() as $value) {
            $route_name = $value->getName();
            $name = str_replace(['create','edit'],['store','update'],$route_name);
            if (in_array($name, Permission::PUBLIC_ROUTES) || is_null($name) || in_array(str_before($name, '.'), ['ignition', 'debugbar']) || !str_contains($value->getPrefix(),'api/v1/dashboard') || $permissions->contains('name',$name) ) {
                continue;
            }
            $permissions->push(self::create(['name' => $name]));
        }
        $permissions->transform(function ($item) {
            return self::getTransPermission($item);
        });
        return $permissions;
    }

    private static function getTransPermission($item)
    {
        return [
            'id' => $item->id,
            'uri' => $item->main_program,
            'named_uri' => $item->name,
            'name' => $item->main_program_trans . ' (' . $item->action_trans . ')',
            'action' => $item->action_trans
        ];
    }
    #endregion custom Methods
}
