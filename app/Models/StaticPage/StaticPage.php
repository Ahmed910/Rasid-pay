<?php

namespace App\Models\StaticPage;

use App\Models\Link;
use App\Models\User;
use App\Traits\Uuid;
use App\Traits\Loggable;
use App\Models\ActivityLog;
use Illuminate\Support\Str;
use App\Traits\HasAssetsTrait;
use App\Contracts\HasAssetsInterface;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;

class StaticPage extends Model implements TranslatableContract, HasAssetsInterface
{
    use Uuid, HasAssetsTrait, Translatable, Loggable;
    #region properties
    protected $appends = ['image'];
    protected $guarded = ['created_at', 'deleted_at'];
    public $translatedAttributes = ['name', 'description'];
    public $assets = ["image"];
    public $with = ["images", "addedBy",'translations'];
    public $sortableColumns = ['name', 'is_active', 'created_at'];

    #endregion properties

    public static function boot()
    {
        parent::boot();
        static::saved(function ($model) {
            $model->saveAssets($model, request());
        });
    }
    #region mutators
    #endregion mutators

    #region scopes
    public function scopeSearch(Builder $query, $request)
    {
        $old = $query->toSql();

        if (isset($request->name)) {
            $query->where(function ($q) use ($request) {
                $q->whereTranslationLike('name', "%$request->name%");
            });
        }
        if (isset($request->is_active) && in_array($request->is_active, [1, 0])) {
            $query->where('is_active', $request->is_active);
        }
        $new = $query->toSql();
        if ($old != $new)  Loggable::addGlobalActivity($this, $request->query(), ActivityLog::SEARCH, 'index');
    }

    public function scopeSortBy(Builder $query, $request)
    {
        if (!isset($request->sort["column"]) || !isset($request->sort["dir"])) return $query->latest('static_pages.created_at');

        if (
            !in_array(Str::lower($request->sort["column"]), $this->sortableColumns) ||
            !in_array(Str::lower($request->sort["dir"]), ["asc", "desc"])
        ) {
            return $query->latest('static_pages.created_at');
        }

        $query->when($request->sort, function ($q) use ($request) {
            if ($request->sort["column"] == "name") {
                return $q->has('translations')
                    ->orderBy($request->sort["column"], @$request->sort["dir"])->latest();
            }

            if ($request->sort["column"] == "is_active") {
                return $q->orderBy('is_active', $request->sort['dir'])->latest();
            }

            $q->orderBy($request->sort["column"], @$request->sort["dir"])->latest();
        });
    }

    #endregion scopes

    #region relationships
    public function addedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'added_by_id');
    }

    public function link(): HasOne
    {
        return $this->hasOne(Link::class, 'static_page_id');
    }
    #endregion relationships

    #region custom Methods
    #endregion custom Methods
}
