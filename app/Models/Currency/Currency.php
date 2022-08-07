<?php

namespace App\Models\Currency;

use App\Models\BankTransfer;
use App\Models\Country\Country;
use App\Models\User;
use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Currency extends Model implements TranslatableContract

{
    use HasFactory, Uuid, Translatable, SoftDeletes, Loggable;

    #region properties
    protected $guarded = ['created_at','deleted_at'];
    public $translatedAttributes = ['name'];
    #endregion properties

    #region mutators
    #endregion mutators

    #region scopes
    #endregion scopes

    #region relationships
    public function countries(): HasMany
    {
        return $this->hasMany(Country::class);
    }
    public function addedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'added_by_id');
    }
    public function bankTransfer()
    {
        return $this->hasMany(BankTransfer::class);
    }
    #endregion relationships

    #region custom Methods
    #endregion custom Methods
}
