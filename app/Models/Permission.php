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
        'group_permissions'
    ];
    #endregion properties

    #region mutators
    #endregion mutators

    #region scopes
    #endregion scopes

    #region relationships
    public function groups()
    {
        return $this->belongsToMany(Group::class);
    }
    #endregion relationships

    #region custom Methods
    public static function permissions($dashboard_type = 'dashboard_blade')
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
    #endregion custom Methods
}
