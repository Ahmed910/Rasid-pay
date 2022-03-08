<?php

namespace App\Models\City;

use App\Models\User;
use App\Traits\Uuid;
use App\Traits\Loggable;
use App\Models\Region\Region;
use App\Models\Country\Country;
use Astrotomic\Translatable\Contracts;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class City extends Model implements Contracts\Translatable
{
    use HasFactory, SoftDeletes, Translatable, Uuid, Loggable;

    #region properties
    protected $guarded = ['created_at','deleted_at'];
    public $translatedAttributes = ['name'];
    protected $with = ['addedBy'];

    #endregion properties

    #region mutators
    #endregion mutators

    #region scopes
    #endregion scopes

    #region relationships
    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
        // return $this->hasOneThrough(Country::class, Region::class, 'id', 'id', 'region_id', 'country_id');

    }

    public function addedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'added_by_id');
    }
    #endregion relationships

    #region custom Methods
    #endregion custom Methods

}
