<?php

namespace App\Models\BankBranch;

use App\Models\ActivityLog;
use App\Models\Bank\Bank;
use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BankBranch extends Model
{
    use HasFactory, Uuid, SoftDeletes, Loggable;

    #region properties
    protected $guarded = ['created_at', 'deleted_at'];
    private $sortableColumns = ["name", "type", "code", "branch_name", 'site', 'transfer_amount', 'transactions_count', 'is_active'];

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

        $this->addGlobalActivity($this, $request->query(), ActivityLog::SEARCH, 'index');
    }

    public function scopeSortBy(Builder $query, Request $request)
    {
        if (
            !isset($request->sort["column"])
            || !isset($request->sort["dir"])
            || !in_array(Str::lower($request->sort["column"]), $this->sortableColumns)
            || !in_array(Str::lower($request->sort["dir"]), ["asc", "desc"])
        ) {
            return $query->latest();
        }

        $query->when($request->sort, function ($q) use ($request) {
            if ($request->sort["column"] == "name") {
                return $q->has('bank.translations')
                    ->orderBy('name', @$request->sort["dir"]);
            }

            if ($request->sort["column"] == "transactions_count") {
                return $q->where(function ($query) {
                    $query->where(function ($q) {
                        $q->selectRaw('COUNT(*) as transaction_count')
                            ->from('transactions')
                            ->where('banks.id', 'transactions.bank_id');
                    })->orderBy('transaction_count');
                });
            }

            $q->orderBy($request->sort["column"], @$request->sort["dir"]);
        });
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
