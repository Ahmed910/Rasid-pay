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

class StaticPage extends Model implements TranslatableContract, HasAssetsInterface
{
    use HasFactory, Uuid, HasAssetsTrait, Translatable, SoftDeletes, Loggable;


    #region properties
    protected $appends = ['image'];
    protected $guarded = ['created_at', 'deleted_at'];
    public $translatedAttributes = ['name', 'description'];
    public $assets = ["image"];
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
    #endregion scopes

    #region relationships
    #endregion relationships

    #region custom Methods
    #endregion custom Methods
}
