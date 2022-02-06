<?php

namespace App\Models\City;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;

class CityTranslation extends Model
{
    use HasFactory, Uuid;

    #region properties
    protected $guarded = ['created_at','updated_at','deleted_at'];
    #endregion properties

    #region mutators
    #endregion mutators

    #region scopes
    #endregion scopes

    #region relationships
    #endregion relationships

    #region custom Methods
    #endregion custom Methods
    public $timestamps = false;


}
