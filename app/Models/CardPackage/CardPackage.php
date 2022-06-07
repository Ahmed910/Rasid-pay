<?php

namespace App\Models\CardPackage;

use App\Models\CitizenPackage;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Contracts\HasAssetsInterface;
use App\Traits\HasAssetsTrait;
use App\Models\User;
use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CardPackage extends Model implements HasAssetsInterface
{
    use HasFactory, Uuid, SoftDeletes, HasAssetsTrait, Loggable;

    protected $appends = ['image'];
    public $assets = ["image"];
    public $with = ["images", "addedBy"];
    protected $guarded = ['created_at', 'updated_at'];
    protected $attributes = ["is_active" => true];

    const BASIC = 'basic';
    const GOLDEN = 'golden';
    const PLATINUM = 'platinum';

    const CARD_TYPES =  [
        self::BASIC,
        self::GOLDEN,
        self::PLATINUM
    ];

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
    public function citizenPackages()
    {
        return $this->hasMany(CitizenPackage::class);
    }

    public function client()
    {
        return $this->belongsTo(User::class,'client_id');
    }
    #endregion relationships

    #region custom Methods
    public static function getTransCards()
    {
        $cards = self::CARD_TYPES;

        $data = collect($cards)->transform(function ($card) {
            $data['name'] = $card;
            $data['trans'] = __("dashboard.citizens.card_type.$card");

            return $data;
        })->values()->toArray();

        return $data;
    }
    #endregion custom Methods
}
