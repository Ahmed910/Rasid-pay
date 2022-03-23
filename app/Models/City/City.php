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
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class City extends Model implements Contracts\Translatable
{
    use HasFactory, SoftDeletes, Translatable, Uuid, Loggable;

    #region properties
    protected $guarded = ['created_at', 'deleted_at'];
    public $translatedAttributes = ['name'];
    protected $with = ['addedBy'];
    private $sortableColumns = ["name", "country_name", "region_name", "created_at", 'postal_code'];

    #endregion properties

    #region mutators
    #endregion mutators

    #region scopes
    public function scopeSortBy(Builder $query, $request)
    {
        if (!isset($request->sort["column"]) || !isset($request->sort["dir"])) return $query->latest('created_at');

        if (
            !in_array(Str::lower($request->sort["column"]), $this->sortableColumns) ||
            !in_array(Str::lower($request->sort["dir"]), ["asc", "desc"])
        ) {
            return $query->latest('created_at');
        }


        $query->when($request->sort, function ($q) use ($request) {
            if ($request->sort["column"]  == "name") {
                return $q->has('translations')
                    ->orderByTranslation($request->sort["column"], @$request->sort["dir"]);
            }

            //TODO: Add Implementation
            if ($request->sort["column"] == "country_name") {
                return ;
            }

            if ($request->sort["column"] == "region_name") {
                return ;
            }

            $q->orderBy($request->sort["column"], @$request->sort["dir"]);
        });
    }
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
