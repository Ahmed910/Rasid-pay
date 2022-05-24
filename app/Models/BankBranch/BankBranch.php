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

    const ISLAMIC = 'islamic';
    const INVESTMENT = 'investment';
    const CENTERAL = 'centeral';
    const TYPES = [
        self::ISLAMIC,
        self::INVESTMENT,
        self::CENTERAL
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
