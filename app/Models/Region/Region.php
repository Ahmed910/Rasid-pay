<?php

namespace App\Models\Region;

use App\Models\City\City;
use App\Models\Country\Country;
use App\Traits\Loggable;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Region extends Model implements TranslatableContract
{
    use HasFactory, SoftDeletes, Uuid, Translatable, Loggable;

    #region properties
    public $translatedAttributes = ['name'];
    protected $guarded = ['created_at', 'updated_at', 'deleted_at'];
    #endregion properties

    #region mutators
    #endregion mutators

    #region scopes
    public function scopeSearch(Builder $query, $request)
    {

        if ($request->name) {
            $query->whereTranslationLike('name', "%$request->name%");
        }

        if (isset($request->created_at)) {

            $query->whereDate('created_at', $request->created_at);
        }

    }
    #endregion scopes

    #region relationships
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function cities(): HasMany
    {
        return $this->hasMany(City::class);
    }
    #endregion relationships

    #region custom Methods
    #endregion custom Methods
}
