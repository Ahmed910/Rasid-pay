<?php

namespace App\Models\Group;

use App\Models\{Permission, User};
use App\Traits\{Loggable, Uuid};
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
        if ($request->search) {
            $query->whereTranslationLike('name',"%$request->search%");
        }

        if ($request->created_at) {

            $query->whereDate('created_at', $request->created_at);
        }

        if ($request->is_active) {
            $query->where('is_active', $request->is_active);
        }

        if ($request->admins_from) {
            $query->withCount('admins as admins_from')->having('admins_from',">=" , $request->admins_from);
        }

        if ($request->admins_to) {
            $query->withCount('admins as admins_to')->having('admins_to',"<=" , $request->admins_to);
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

    public function addedBy()
    {
        return $this->belongsTo(User::class,'added_by_id');
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }
    #endregion relationships

    #region custom Methods
    #endregion custom Methods
}
