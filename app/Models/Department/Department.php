<?php

namespace App\Models\Department;

use App\Contracts\HasAssetsInterface;
use App\Models\ActivityLog;
use App\Models\RasidJob\RasidJob;
use App\Models\User;
use App\Traits\HasAssetsTrait;
use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class Department extends Model implements TranslatableContract, HasAssetsInterface
{
    use HasFactory, Uuid, HasAssetsTrait, Translatable, SoftDeletes, Loggable;


    #region properties
    protected $appends = ['image'];
    protected $guarded = ['created_at', 'deleted_at'];
    public $translatedAttributes = ['name', 'description'];
    public $assets = ["image"];
    public $with = ["images", "addedBy"];
    private $sortableColumns = ["name", "parent", "created_at", "status", 'is_active'];
    private static $result = [];

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


    #region accessor


    public function getImageAttribute()
    {
        if ($this->images()->first()?->media == null) return null;

        return asset($this->images()->first()?->media);
    }
    #endregion accessor

    #region scopes
    public function scopeSearch(Builder $query, $request)
    {
        $this->addGlobalActivity($this, $request->query(), ActivityLog::SEARCH, 'index');

        if ($request->name) {
            $query->where(function ($q) use ($request) {
                $q->whereTranslationLike('name', "%\\$request->name%");
            });
        }

        if (isset($request->parent_id)) {
            $query->where("parent_id", $request->parent_id);
        }

        if (isset($request->is_active)) {
            if (!in_array($request->is_active, [1, 0])) return;

            $query->where('is_active', $request->is_active);
        }
    }

    public function scopeSortBy(Builder $query, $request)
    {

        if (!isset($request->sort["column"]) || !isset($request->sort["dir"])) return $query->latest('departments.created_at');

        if (
            !in_array(Str::lower($request->sort["column"]), $this->sortableColumns) ||
            !in_array(Str::lower($request->sort["dir"]), ["asc", "desc"])
        ) {
            return $query->latest('departments.created_at');
        }


        $query->when($request->sort, function ($q) use ($request) {
            if ($request->sort["column"] == "name") {
                return $q->has('translations')
                    ->orderBy($request->sort["column"], @$request->sort["dir"]);
            }

            if ($request->sort["column"] == "parent") {
                return $q->orderBy('parent_id', $request->sort['dir']);
            }

            $q->orderBy($request->sort["column"], @$request->sort["dir"]);
        });
    }
    #endregion scopes

    #region relationships
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Department::class, 'parent_id')->with("children");
    }


    public function rasidJobs()
    {
        return $this->hasMany(RasidJob::class, 'department_id');
    }

    public function addedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'added_by_id');
    }


    public static function flattenChildren($parent)
    {
        self::$result[] = $parent->id;
        foreach ($parent->children as $child) {
            self::$result[] = $child->id;
            static::flattenChildren($child);
        }
        return self::$result;
    }

    #endregion relationships

    #region custom Methods
    #endregion custom Methods
}
