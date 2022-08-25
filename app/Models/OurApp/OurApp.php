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
    public $with = ["images",'translations'];
    private static $result = [];
    private $sortableColumns = ['name', 'order', 'is_active', 'created_at'];

    #endregion properties

    #region mutators

    public static function boot()
    {
        parent::boot();
        static::saved(function ($model) {
            $model->saveAssets($model, request());
        });
    }

    public function getPhotoAttribute()
    {
        return asset($this->images()->where('option', 'image')->first()?->media);
    }
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
        if ($old != $new || $request->is_active == -1)  Loggable::addGlobalActivity(
            $this, array_merge($request->query(), $this->searchParams($request)), ActivityLog::SEARCH, 'index');
    }

    public function scopeSortBy(Builder $query, $request)
    {

        if (!isset($request->sort["column"]) || !isset($request->sort["dir"]))
            return $query->orderBy('our_apps.order')->latest('our_apps.created_at');

        if (
            !in_array(Str::lower($request->sort["column"]), $this->sortableColumns) ||
            !in_array(Str::lower($request->sort["dir"]), ["asc", "desc"])
        ) {
            return $query->orderBy('our_apps.created_at')->latest('our_apps.created_at');
        }

        $query->when($request->sort, function ($q) use ($request) {
            if ($request->sort["column"] == "name") {
                return $q->has('translations')
                    ->orderBy($request->sort["column"], @$request->sort["dir"])->latest('our_apps.created_at');
            }

            $q->orderBy($request->sort["column"], @$request->sort["dir"])->latest('our_apps.created_at');
        });
    }

    #endregion scopes

    #region relationships
    #endregion relationships

    #region custom Methods
    private function searchParams($request){
        $searchParams = [];
        if($request->has('is_active')){
            $searchParams['is_active'] = __('dashboard.our_app.active_cases.'. $request->is_active);
        }

        return $searchParams;
    }
    #endregion custom Methods
}
