<?php

namespace App\Models\Role;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Role extends Model implements TranslatableContract
{
    use HasFactory, Translatable, Uuid;

     #region properties
     protected $guarded = ["created_at", "updated_at"];
     public $translatedAttributes = ['name'];
     #endregion properties

     #region mutators
     #endregion mutators

     #region scopes
     #endregion scopes

     #region relationships
     #endregion relationships

     #region custom Methods
     #endregion custom Methods
}
