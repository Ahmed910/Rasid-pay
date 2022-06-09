<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\RecieveOption\RecieveOption;
use App\Models\Country\Country;
use App\Traits\Uuid;

class Beneficiary extends Model
{
    use HasFactory, Uuid , SoftDeletes;

    #region properties
    protected $guarded = ['created_at','deleted_at'];
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
    public function user()
    {
        return $this->belongsTo(User::class,'citizen_id');
    }

    public function bankTransfer()
    {
        return $this->hasMany(BankTransfer::class);
    }

    public function recieveOption()
    {
        return $this->belongsTo(RecieveOption::class,'recieve_option_id');
    }


    #endregion relationships

    #region custom Methods
    #endregion custom Methods
}
