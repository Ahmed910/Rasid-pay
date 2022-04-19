<?php

namespace App\Models\CardPackage;

use App\Traits\Uuid;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CardPackage extends Model
{
    use HasFactory, Uuid, Translatable;

    protected $guarded = ['created_at', 'updated_at'];
    public $translatedAttributes = ['name', 'description'];
    protected $attributes = ["is_active" => true, "available_for_promo" => true];

    #region properties
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
