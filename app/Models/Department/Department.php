<?php

namespace App\Models\Department;

use App\Contracts\HasAssetsInterface;
use App\Traits\HasAssetsTrait;
use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;


class Department extends Model implements TranslatableContract, HasAssetsInterface
{
    use HasFactory, Uuid, HasAssetsTrait, Translatable, SoftDeletes, Loggable;

    #region properties

    #region properties
    protected $guarded = ['created_at', 'updated_at', 'deleted_at'];
    public $translatedAttributes = ['name', 'description'];
    public $assets = ["image"];
    public $with   = ["images"];
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

        $query->whereHas("translations", function ($q) use ($request) {
            $q->where('name', 'LIKE', "%$request->name%");
        });

        if (isset($request->created_at)) {

            $query->whereDate('created_at', $request->created_at);
        }

        if (isset($request->parent_id)) {
            $query->where("parent_id", $request->parent_id);
        }

        if (isset($request->is_active)) {

            $query->where('is_active', $request->is_active);
        }
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



    #endregion relationships

    #region custom Methods
    #endregion custom Methods
}
