<?php

namespace App\Models;

use App\Models\TransferPurpose\TransferPurpose;
use App\Traits\{Loggable,Uuid};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\TransferPurpose\TransferPurpose;
use App\Models\RecieveOption\RecieveOption;
use App\Models\Currency\Currency;

class BankTransfer extends Model
{
    use HasFactory, Uuid, Loggable, SoftDeletes;
    protected $guarded = ['created_at','updated_at', 'deleted_at'];

    #region properties
    #endregion properties

    #region mutators
    #endregion mutators

    #region scopes
    #endregion scopes

    #region relationships

    public function beneficiary(): BelongsTo
    {
        return $this->belongsTo(Beneficiary::class, 'beneficiary_id');
    }


    public function recieveOption(): BelongsTo
    {
        return $this->belongsTo(RecieveOption::class, 'recieve_option_id');
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }

    public function toCurrency(): BelongsTo
    {
        return $this->belongsTo(Currency::class, 'to_currency_id');
    }
    public function transferPurpose(): BelongsTo
    {
        return $this->belongsTo(TransferPurpose::class, 'transfer_purpose_id');
    }




    public function transfers()
    {
        return $this->hasMany(Transfer::class);
    }


   
    #endregion relationships

    #region custom Methods
    #endregion custom Methods
}
