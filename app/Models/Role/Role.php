<?php

namespace App\Models\Role;

use App\Models\Permission;
use App\Models\User;
use App\Traits\Loggable;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Role extends Model implements TranslatableContract
{
    use HasFactory, Translatable, Uuid, Loggable;

    #region properties
    protected $guarded = ["created_at", "updated_at"];
    public $translatedAttributes = ['name'];
    #endregion properties

    #region mutators
    #endregion mutators

    #region scopes
    public function scopeSearch($q, $request)
    {
        $q->when($request->name, function($q) use ($request){
            $q->whereTranslationLike('name', "%$request->name%");
        });
    }
    #endregion scopes

    #region relationships
    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }
    #endregion relationships

    #region custom Methods
    #endregion custom Methods
}
