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
        "image_delete.image_delete",
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
    #endregion custom Methods
}
