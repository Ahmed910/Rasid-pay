<?php

namespace App\Models\Package;

use App\Models\CitizenPackage;
use App\Traits\Uuid;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Contracts\HasAssetsInterface;
use App\Traits\HasAssetsTrait;
use App\Models\User;
use App\Traits\Loggable;

class Package extends Model implements HasAssetsInterface
{
    use HasFactory, Uuid, SoftDeletes, HasAssetsTrait, Loggable,Translatable;

    protected $guarded = ['created_at', 'updated_at'];
    protected $attributes = ["is_active" => true, 'duration' => 12];
    public $translatedAttributes = ['name', 'description'];

    #region properties
    public static function boot()
    {
        parent::boot();
        static::saved(function ($model) {
            $model->saveAssets($model, request());
        });
    }
    #endregion properties

    #region mutators
    #endregion mutators

    #region scopes
    #endregion scopes

    #region relationships

    public function citizenPackages()
    {
        return $this->hasMany(CitizenPackage::class);
    }

    public function clients()
    {
        return $this->belongsToMany(User::class,'client_package','client_id','package_id')->withPivot('package_discount');
    }
    #endregion relationships

    #region custom Methods

    #endregion custom Methods
}
