<?php

namespace App\Models\BankBranch;

use App\Models\Bank\Bank;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

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
    public function scopeSearch(Builder $query, Request $request)
    {
        if ($request->has('type'))
            $query->where('type', $request->type);

        if ($request->has('code'))
            $query->where('code', $request->code);

        if ($request->has('is_active') && in_array($request->is_active, [1, 0]))
            $query->where('is_active', $request->is_active);

        if ($request->has('branch_name'))
            $query->where('name', 'like', "%$request->branch_name%");

        if ($request->has('site'))
            $query->where('site', "like", "%$request->site%");

        if ($request->has('transfer_amount'))
            $query->where('transfer_amount', $request->transfer_amount);

        $query->whereHas('bank', fn ($q) => $q->search($request));
    }
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
