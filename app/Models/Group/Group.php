<?php

namespace App\Models\Group;

use App\Models\Permission;
use App\Models\User;
use App\Traits\Loggable;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Group extends Model implements TranslatableContract
{
    use HasFactory, Translatable, Uuid, Loggable;

    #region properties
    protected $guarded = ["created_at", "updated_at"];
    public $translatedAttributes = ['name'];
    public $attributes = ['is_active' => false];
    #endregion properties

    #region mutators
    #endregion mutators

    #region scopes
    public function scopeSearch($query, $request)
    {
        if ($request->name) {
            $query->whereTranslationLike('name',"%$request->name%");
        }

        if ($request->created_at) {

            $query->whereDate('created_at', $request->created_at);
        }

        if ($request->is_active) {
            $query->where('is_active', $request->is_active);
        }
    }

    public function scopeActive($query)
    {
        $query->where('is_active',true);
    }
    #endregion scopes

    #region relationships
    public function admins()
    {
        return $this->belongsToMany(User::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }
    #endregion relationships

    #region custom Methods
    #endregion custom Methods
}
