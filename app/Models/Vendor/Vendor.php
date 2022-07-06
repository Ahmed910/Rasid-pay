<?php

namespace App\Models\Vendor;

use App\Contracts\HasAssetsInterface;
use App\Traits\HasAssetsTrait;
use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Astrotomic\Translatable\Translatable;

class Vendor extends Model implements HasAssetsInterface
{
    use HasFactory, Uuid, HasAssetsTrait, Loggable, Translatable;

    #region properties
    const TYPES = ['company', 'institution', 'member', 'freelance_doc', 'famous', 'other'];
    public $assets = ['logo', 'commercial_record_image', 'tax_number_image'];
    protected $guarded = ['created_at'];
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
    public function vendorBranches()
    {
        return $this->hasMany(VendorBranch::class);
    }
    #endregion relationships

    #region custom Methods
    #endregion custom Methods
}
