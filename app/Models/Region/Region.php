<?php

namespace App\Models\Region;

use App\Models\ActivityLog;
use App\Models\City\City;
use App\Models\Country\Country;
use App\Models\User;
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
use Illuminate\Support\Str;

class Region extends Model implements TranslatableContract
{
    use HasFactory, SoftDeletes, Uuid, Translatable, Loggable;

    #region properties
    public $translatedAttributes = ['name'];
    protected $guarded = ['created_at','deleted_at'];
    private $sortableColumns = ["name", "created_at"];
    protected $with = ['addedBy'];
    #endregion properties

    #region mutators
    #endregion mutators

    #region scopes
    public function scopeSearch(Builder $query, $request)
    {
        $this->addGlobalActivity($this, $request->query(), ActivityLog::SEARCH,'index');

        if ($request->name) {
            $query->whereTranslationLike('name', "%$request->name%");
        }

        if (isset($request->created_at)) {

            $query->whereDate('created_at', $request->created_at);
        }

    }

    public function scopeSortBy(Builder $query, $request)
    {

        if (!isset($request->sort["column"]) || !isset($request->sort["dir"])) return $query->latest('regions.created_at');

        if (
            !in_array(Str::lower($request->sort["column"]), $this->sortableColumns) ||
            !in_array(Str::lower($request->sort["dir"]), ["asc", "desc"])
        ) {
            return $query->latest('regions.created_at');
        }


        $query->when($request->sort, function ($q) use ($request) {
            if ($request->sort["column"] == "name") {
                return $q->has('translations')
                    ->orderBy($request->sort["column"], @$request->sort["dir"]);
            }


            $q->orderBy($request->sort["column"], @$request->sort["dir"]);
        });
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

    public function addedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'added_by_id');
    }
    #endregion relationships

    #region custom Methods
    #endregion custom Methods
}
