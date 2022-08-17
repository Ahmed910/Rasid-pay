<?php

namespace App\Models\BankBranch;

use App\Models\ActivityLog;
use App\Models\Bank\Bank;
use App\Models\Transaction;
use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BankBranch extends Model
{
    use HasFactory, Uuid, Loggable, Translatable;

    #region properties
    protected $guarded = ['created_at', 'deleted_at'];
    private $sortableColumns = ["name", "type", "code", "branch_name", 'site', 'transfer_amount', 'transactions_count', 'is_active'];
    public $translatedAttributes = ['name'];
    public $with = ['translations'];

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
        $old = $query->toSql();
        if ($request->has('type')  && $request->type!=-1)
            $query->where('type', $request->type);

        if ($request->has('code'))
            $query->where('code', $request->code);

        if ($request->has('is_active') && in_array($request->is_active, [1, 0]))
            $query->where('is_active', $request->is_active);

        if ($request->has('branch_name'))
            $query->whereTranslationLike('name', "%$request->branch_name%");

        if ($request->has('site'))
            $query->where('site', "like", "%$request->site%");

        if ($request->has('transfer_amount'))
            $query->where('transfer_amount', $request->transfer_amount);
        $new = $query->toSql();

        if ($old != $new) Loggable::addGlobalActivity($this, $request->query(), ActivityLog::SEARCH, 'index');
        $query->whereHas('bank', fn ($q) => $q->search($request));


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
                return $q->has('bank')->orderByTranslation('name', @$request->sort["dir"])->latest();
            }

            if ($request->sort["column"] == "branch_name") {
                return $q->join('bank_branch_translations','bank_branches.id','bank_branch_id')
                    ->orderBy('bank_branch_translations.name', @$request->sort["dir"])->latest();
            }

            if ($request->sort["column"] == "transactions_count") {
                return $q->withCount('transactions')
                    ->orderBy('transactions_count', @$request->sort['dir'])->latest();
            }

            $q->orderBy($request->sort["column"], @$request->sort["dir"])->latest();
        });
    }
    #endregion scopes

    #region relationships
    public function bank(): BelongsTo
    {
        return $this->belongsTo(Bank::class);
    }

    /**Custom according on relationships */
    public function transactions()
    {
        return $this->hasManyThrough(Transaction::class, Bank::class, 'id', null, 'bank_id');
    }
    #endregion relationships

    #region custom Methods
    #endregion custom Methods
}
