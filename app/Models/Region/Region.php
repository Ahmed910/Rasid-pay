<?php

namespace App\Models\Region;

use App\Models\City\City;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Region  extends Model implements TranslatableContract
{
    use HasFactory, SoftDeletes, Uuid, Translatable;

    #region properties
    public $translatedAttributes = ['name'];
    protected $guarded = ['created_at', 'updated_at', 'deleted_at'];
    #endregion properties

    #region mutators
    #endregion mutators

    #region scopes
    #endregion scopes

    #region relationships
    public function country()
    {
        return $this->belongsTo(country::class, 'country_id', 'id');
    }
    public function cities()
    {
        return $this->hasMany(City::class, 'region_id', 'id');
    }
    #endregion relationships

    #region custom Methods
    #endregion custom Methods
}
