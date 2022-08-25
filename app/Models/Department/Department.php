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
    public $with = ["images", "addedBy", 'translations'];
    private $sortableColumns = ["name", "parent", "created_at", "status", 'is_active', 'deleted_at'];
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



    #endregion accessor

    #region scopes
    public function scopeSearch(Builder $query, $request, $subProgram = 'index')
    {
        $old = $query->toSql();

        if (isset($request->name)) {
            $query->where(function ($q) use ($request) {
                $q->whereTranslationLike('name', "%\\$request->name%");
            });
        }

        if (isset($request->parent_id)) {
            if ($request->parent_id == 0) $request->parent_id = null;
            if ($request->parent_id != -1)  $query->where("parent_id", $request->parent_id);
        }

        if (isset($request->is_active) && in_array($request->is_active, [1, 0])) {
            $query->where('is_active', $request->is_active);
        }

        if ($request->has('deleted_from') || $request->has('deleted_to')) {
            $query->customDateFromTo($request, 'deleted_at', 'deleted_from', 'deleted_to');
        }

        $new = $query->toSql();
        if ($old != $new || $request->is_active == -1 || $request->parent_id == -1)
            Loggable::addGlobalActivity($this, array_merge($request->query(), $this->searchParams($request)), ActivityLog::SEARCH, $subProgram);
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
                    ->orderBy($request->sort["column"], @$request->sort["dir"])->latest('departments.created_at');
            }

            if ($request->sort["column"] == "parent") {
                return $q->leftJoin('departments as parents', 'parents.id', 'departments.parent_id')
                    ->leftJoin('department_translations as trans', 'trans.department_id', 'parents.id')
                    ->orderBy('trans.name', @$request->sort["dir"]);
            }

            $q->orderBy($request->sort["column"], @$request->sort["dir"])->latest('departments.created_at');
        });
    }
    #endregion scopes

    #region relationships
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'parent_id')->withTrashed();
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
    private function searchParams($request)
    {
        $searchParams = [];
        if ($request->has('is_active')) {
            $searchParams['is_active'] = __('dashboard.department.active_cases.' . $request->is_active);
        }

        if ($request->has('parent_id') && $request->parent_id == null) {
            $searchParams['parent_id'] = __('dashboard.department.parent_cases.without');
        } elseif ($request->has('parent_id') && $request->parent_id == -1) {
            $searchParams['parent_id'] = __('dashboard.department.parent_cases.all');
        } elseif ($request->has('parent_id')) {
            $searchParams['parent_id'] = Department::find($request->parent_id)?->name;
        }
        return $searchParams;
    }
    #endregion custom Methods
}
