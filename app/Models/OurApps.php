<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Contracts\HasAssetsInterface;
use App\Traits\HasAssetsTrait;
use Astrotomic\Translatable\Translatable;
use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Builder;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use App\Traits\Uuid;

class OurApps extends Model implements TranslatableContract, HasAssetsInterface
{
    use HasFactory, Uuid, HasAssetsTrait, Translatable, Loggable;

    #region properties
    protected $appends = ['image'];
    protected $guarded = ['created_at'];
    public $translatedAttributes = ['name', 'description'];
    public $assets = ["image"];
    public $with = ["images"];
    private static $result = [];
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
    #endregion scopes

    #region relationships
    #endregion relationships

    #region custom Methods
    #endregion custom Methods
}
