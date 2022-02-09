<?php

namespace App\Models\Country;

use App\Models\City\City;
use App\Models\Currency;
use App\Models\Region\Region;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Carbon\Carbon;

class Country extends Model implements TranslatableContract
{
    use HasFactory;
    use Translatable;

    #region properties
    protected $guarded = ['created_at', 'updated_at', 'deleted_at'];
    public $translatedAttributes = ['name', 'nationality', 'phone_code'];
    #endregion properties

    #region mutators
    #endregion mutators

    #region scopes
    #endregion scopes

    #region relationships
    public function regions()
    {
        return $this->hasMany(Region::class, 'region_id', 'id');
    }

    public function cities()
    {
        return $this->hasMany(City::class, 'city_id', 'id');
        // return $this->hasManyThrough(City::class, Region::class, 'region_id', 'city_id', 'id', 'id');

    }

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id', 'id');
    }
    #endregion relationships

    #region custom Methods

    public function getCreatedAtAttribute($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('Y-m-d h:i a');
    }
    #endregion custom Methods

}
