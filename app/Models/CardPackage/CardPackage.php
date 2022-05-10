<?php

namespace App\Models\CardPackage;

use App\Models\CitizenCard;
use App\Traits\Uuid;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Contracts\HasAssetsInterface;
use App\Traits\HasAssetsTrait;
use App\Models\User;
use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;







class CardPackage extends Model implements  HasAssetsInterface
{
    use HasFactory, Uuid, SoftDeletes,Translatable ,HasAssetsTrait,Loggable;

    protected $appends = ['image'];
    public $assets = ["image"];
    public $with = ["images", "addedBy"];
    protected $guarded = ['created_at', 'updated_at'];
    public $translatedAttributes = ['name', 'description'];
    protected $attributes = ["is_active" => true, "available_for_promo" => true];

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
    public function addedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'added_by_id');
    }
    public function citizenCards () {
        return $this->hasMany(CitizenCard::class) ;
    }
    #endregion relationships

    #region custom Methods
    #endregion custom Methods
}
