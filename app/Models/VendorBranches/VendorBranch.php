<?php

namespace App\Models\VendorBranches;

use App\Contracts\HasAssetsInterface;
use App\Traits\{HasAssetsTrait,Loggable,Uuid};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;

class VendorBranch extends Model implements HasAssetsInterface
{
    use HasFactory, Uuid, HasAssetsTrait, Loggable, Translatable;

    #region properties
    public $assets = ['branch_image'];
    protected $guarded = ['created_at', 'deleted_at'];
    public $translatedAttributes = ['name'];
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
    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
    #endregion relationships

    #region custom Methods
    #endregion custom Methods
}
