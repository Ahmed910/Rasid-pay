<?php

namespace App\Models\Locale;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Astrotomic\Translatable\Translatable;

class Locale extends Model
{
    use HasFactory, Uuid, Translatable;

    #region properties
    protected $guarded = ["created_at", "created_at"];
    protected $with = ["translations"];
    public $translatedAttributes = ['value', 'desc'];
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
