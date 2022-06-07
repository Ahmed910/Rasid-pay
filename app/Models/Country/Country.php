<?php

namespace App\Models\Country;

use App\Models\City\City;
use App\Models\Currency\Currency;
use App\Models\Region\Region;
use App\Models\Beneficiary;
use App\Models\User;
use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;


class Country extends Model implements TranslatableContract
{
    use HasFactory, Uuid, Translatable, SoftDeletes, Loggable;

    #region properties
    protected $guarded = ['created_at','deleted_at'];
    public $translatedAttributes = ['name', 'nationality'];
    #endregion properties

    #region mutators
    #endregion mutators

    #region scopes
    #endregion scopes

    #region relationships
    public function regions(): HasMany
    {
        return $this->hasMany(Region::class);
    }

    public function cities(): HasMany
    {
        return $this->hasMany(City::class);
        // return $this->hasManyThrough(City::class, Region::class, 'region_id', 'city_id', 'id', 'id');

    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }

    public function addedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'added_by_id');
    }

    public function beneficiaries(): HasMany
    {
        return $this->hasMany(Beneficiary::class);
    }
    #endregion relationships

    #region custom Methods
    #endregion custom Methods

}
