<?php

namespace App\Models;

use App\Models\Group\Group;
use App\Traits\{Loggable, Uuid};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory, Uuid, Loggable;
    #region properties
    protected $guarded = ["created_at", "updated_at"];
    const PUBLIC_ROUTES = [
        'notifications.index' ,
        'notifications.show' ,
        'notifications.destroy' ,
        'notifications.update' ,
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
        "image_delete",
        "send_message",
        "validate",
        'group_permissions',
        'backButton',
        'home'
    ];
    #endregion properties

    #region mutators
    #endregion mutators

    #region scopes

    public function scopeBlade($query)
    {
        $query->where('permission_on','blade');
    }
    #endregion scopes

    #region relationships
    public function groups()
    {
        return $this->belongsToMany(Group::class);
    }
    #endregion relationships

    #region custom Methods
    public static function getPermissions($dashboard_type = 'dashboard_blade')
    {
        $permissions = Permission::where('permission_on', $dashboard_type)->get();
        foreach (app()->routes->getRoutes() as $value) {
            if(str_contains($value->getPrefix(),'dashboard') && !str_contains($value->getPrefix(),'api')){
                if($value->getName() != 'dashboard.' && !is_null($value->getName())){
                    $path = str_after($value->getName(),'.');
                    $uri = str_replace(['create','edit'],['store','update'],$path);
                    if (!$uri || ($permissions->contains('name',$uri) && $permissions->contains('permission_on',$dashboard_type)) || in_array($uri,self::PUBLIC_ROUTES)) {
                        continue;
                    }
                    $permissions->push(self::create(['name' => $uri,'permission_on' => $dashboard_type]));
                }
            }
        }
        $permissions->transform(function ($item) {
            return self::getTransPermission($item);
        });

        // $permissions = $permissions->groupBy('uri')->map(function ($item,$key) {
        //     $data['program'] = trans('dashboard.'.$key.".".str_plural($key));
        //     $data['permissions'] = $item;
        //     return $data;
        // });

        return $permissions;
    }

    private static function getTransPermission($item)
    {
        $path = explode('.',$item->name);
        $action = trans('dashboard.' . @$path[0] . '.permissions.' . @$path[1]);
        $data['id'] = $item->id;
        $data['uri'] = $path[0];
        $data['named_uri'] = $item->name;
        $data['name'] = trans('dashboard.' . @$path[0] . '.' . str_plural($path[0])) . ' (' . $action . ')';
        $data['action'] = $action;
        return $data;
    }
    #endregion custom Methods
}
