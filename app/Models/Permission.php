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
