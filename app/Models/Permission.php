<?php

namespace App\Models;

use App\Models\Role\Role;
use App\Traits\Loggable;
use App\Traits\Uuid;
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
    ];
    #endregion properties

    #region mutators
    #endregion mutators

    #region scopes
    #endregion scopes

    #region relationships
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
    #endregion relationships

    #region custom Methods
    #endregion custom Methods
}
