<?php

namespace App\Models\BankBranch;

use App\Models\Bank\Bank;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class BankBranch extends Model
{
    use HasFactory, Uuid, SoftDeletes;

    #region properties
    protected $guarded = ['created_at', 'deleted_at'];

    const CENTERAL = 'centeral';
    const COMMERCIAL = 'commercial';
    const BANK = 'bank';
    const INVESTMENT = 'investment';
    const INDUSTRIAL = 'industrial';
    const REAL_ESTATE = 'real_estate';
    const AGRICULTURAL = 'agricultural';
    const ISLAMIC = 'islamic';
    const SAVINGS = 'savings';

    const TYPES = [
        self::CENTERAL,
        self::COMMERCIAL,
        self::BANK,
        self::INVESTMENT,
        self::INDUSTRIAL,
        self::REAL_ESTATE,
        self::AGRICULTURAL,
        self::ISLAMIC,
        self::SAVINGS
    ];
    #endregion properties

    #region mutators
    #endregion mutators

    #region scopes
    #endregion scopes

    #region relationships
    public function bank(): BelongsTo
    {
        return $this->belongsTo(Bank::class);
    }
    #endregion relationships

    #region custom Methods
    #endregion custom Methods
}
