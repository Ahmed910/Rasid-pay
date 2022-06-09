<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\RecieveOption\RecieveOption;
use App\Models\Country\Country;
use App\Traits\Uuid;

class  Beneficiary extends Model
{
    use HasFactory, Uuid, SoftDeletes;

    #region properties
    protected $guarded = ['created_at', 'deleted_at'];
    const LOCAL_TYPE = 'local';
    const GLOBAL_TYPE = 'global';
    const TYPES = [
        self::LOCAL_TYPE,
        self::GLOBAL_TYPE
    ];
    #endregion properties

    #region mutators
    #endregion mutators

    #region scopes

    #endregion scopes

    #region relationships
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function bankTransfer()
    {
        return $this->hasMany(BankTransfer::class);
    }




    public function recieveOption(): BelongsTo
    {
        return $this->belongsTo(RecieveOption::class);
    }
    #endregion relationships

    #region custom Methods
    #endregion custom Methods
}
