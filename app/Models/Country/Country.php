<?php

namespace App\Models\Country;

use App\Models\City\City;
use App\Models\Currency\Currency;
use App\Models\Region\Region;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;


class Country extends Model implements TranslatableContract
{
    use HasFactory, Uuid, Translatable, SoftDeletes;

    #region properties
    protected $guarded = ['created_at', 'updated_at', 'deleted_at'];
    public $translatedAttributes = ['name', 'nationality'];
    #endregion properties

    #region mutators
    #endregion mutators

    #region scopes
    #endregion scopes

    #region relationships
    public function regions()
    {
        return $this->hasMany(Region::class);
    }

    public function cities()
    {
        return $this->hasMany(City::class);
        // return $this->hasManyThrough(City::class, Region::class, 'region_id', 'city_id', 'id', 'id');

    }

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id', 'id');
    }
    #endregion relationships

    #region custom Methods
    #endregion custom Methods

}
