<?php

namespace App\Models\OurApp;

use App\Traits\Uuid;
use App\Traits\Loggable;
use App\Models\ActivityLog;
use Illuminate\Support\Str;
use App\Traits\HasAssetsTrait;
use App\Contracts\HasAssetsInterface;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;

class OurApp extends Model implements TranslatableContract, HasAssetsInterface
{
    use HasFactory, Uuid, HasAssetsTrait, Translatable, Loggable;

    #region properties
    protected $appends = ['image'];
    protected $guarded = ['created_at'];
    public $translatedAttributes = ['name', 'description'];
    public $assets = ["image"];
    public $with = ["images"];
    private static $result = [];
    private $sortableColumns = ['name','order','is_active','created_at'];

    #endregion properties

    #region mutators

    public static function boot()
    {
        parent::boot();
        static::saved(function ($model) {
            $model->saveAssets($model, request());
        });
    }
    #endregion mutators

    #region scopes    
    public function scopeSearch(Builder $query, $request)
    {
        $old = $query->toSql() ;

        if (isset($request->name)) {
            $query->where(function ($q) use ($request) {
                $q->whereTranslationLike('name', "%$request->name%");
            });
        }
        if (isset($request->is_active) && in_array($request->is_active, [1, 0])) {
            $query->where('is_active', $request->is_active);
        }
        $new = $query->toSql() ;
        if ($old!=$new)  $this->addGlobalActivity($this, $request->query(), ActivityLog::SEARCH, 'index');

    }

    public function scopeSortBy(Builder $query, $request)
    {

        if (!isset($request->sort["column"]) || !isset($request->sort["dir"])) return $query->orderBy('our_apps.order');

        if (
            !in_array(Str::lower($request->sort["column"]), $this->sortableColumns) ||
            !in_array(Str::lower($request->sort["dir"]), ["asc", "name"])
        ) {
            return $query->orderBy('our_app.order');
        }

        $query->when($request->sort, function ($q) use ($request) {
            if ($request->sort["column"] == "name") {
                return $q->has('translations')
                    ->orderBy($request->sort["column"], @$request->sort["dir"]);
            }
            if ($request->sort["column"] == "is_active") {
                return $q->orderBy('is_active', $request->sort['dir']);
            }

            $q->orderBy($request->sort["column"], @$request->sort["dir"]);
        });
    }

    #endregion scopes

    #region relationships
    #endregion relationships

    #region custom Methods
    #endregion custom Methods
}
