<?php

namespace App\Models\City;

use App\Models\Country\Country;
use App\Models\Region\Region;
use App\Traits\Uuid;
use Astrotomic\Translatable\Translatable;
use Astrotomic\Translatable\Contracts;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model implements Contracts\Translatable
{
    use HasFactory, SoftDeletes, Translatable,Uuid;

    #region properties
    protected $guarded = ['created_at', 'updated_at', 'deleted_at'];
    public $translatedAttributes = ['name'];
    #endregion properties

    #region mutators
    #endregion mutators

    #region scopes
    #endregion scopes

    #region relationships
    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
        // return $this->hasOneThrough(Country::class, Region::class, 'id', 'id', 'region_id', 'country_id');

    }
    #endregion relationships

    #region custom Methods
    #endregion custom Methods

}
