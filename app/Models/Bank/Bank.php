<?php

namespace App\Models\Bank;

use App\Traits\Uuid;
use App\Traits\Loggable;
use App\Models\ActivityLog;
use App\Models\Transaction;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Traits\HasAssetsTrait;
use App\Contracts\HasAssetsInterface;
use Astrotomic\Translatable\Contracts;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class   Bank extends Model implements Contracts\Translatable ,  HasAssetsInterface

{
    use HasFactory, SoftDeletes, Translatable, Uuid, Loggable , HasAssetsTrait;

    public static function boot()
    {
        parent::boot();
        static::saved(function ($model) {
            $model->saveAssets($model, request());
        });
    }
    #region properties
    protected $guarded = ['created_at', 'deleted_at'];
    public $translatedAttributes = ['name'];
    public $assets = ["image"];
    public $with   = ["images"];
    private $sortableColumns = ["name", "is_active", "created_at"];
    #endregion properties

    #region mutators
    #endregion mutators

    #region scopes
    public function scopeSearch(Builder $query, Request $request)
    {
        $old = $query->toSql();

        if ($request->has('name'))
            $query->whereTranslationLike('name', "%$request->name%");

        if ($request->has('is_active')) 
            $query->where('is_active', $request->is_active);

        $new = $query->toSql();
        if ($old != $new) $this->addGlobalActivity($this, $request->query(), ActivityLog::SEARCH, 'index');
    }

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

            if ($request->sort["column"] == "is_active") {
                $q->orderBy($request->sort["column"], @$request->sort["dir"]);
            }

            $q->orderBy($request->sort["column"], @$request->sort["dir"]);
        });
    }
    #endregion scopes

    #region relationships


    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }
    #endregion relationships

    #region custom Methods
    #endregion custom Methods
}
