<?php

namespace App\Models\Bank;

use App\Models\BankBranch\BankBranch;
use App\Traits\Loggable;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Astrotomic\Translatable\Contracts;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;


class Bank extends Model implements Contracts\Translatable
{
    use HasFactory, SoftDeletes, Translatable, Uuid, Loggable;

    protected $guarded = ['created_at', 'deleted_at'];
    public $translatedAttributes = ['name'];

    #region properties
    #endregion properties

    #region mutators
    #endregion mutators

    #region scopes
    #endregion scopes

    #region relationships
    public function branches(): HasMany
    {
        return $this->hasMany(BankBranch::class);
    }
    #endregion relationships

    #region custom Methods
    #endregion custom Methods
}
