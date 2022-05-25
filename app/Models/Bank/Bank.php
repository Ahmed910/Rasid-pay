<?php

namespace App\Models\Bank;

use App\Models\BankBranch\BankBranch;
use App\Models\Transaction;
use App\Traits\Loggable;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Astrotomic\Translatable\Contracts;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class Bank extends Model implements Contracts\Translatable
{
    use HasFactory, SoftDeletes, Translatable, Uuid, Loggable;

    #region properties
    protected $guarded = ['created_at', 'deleted_at'];
    public $translatedAttributes = ['name'];

    #endregion properties

    #region mutators
    #endregion mutators

    #region scopes
    public function scopeSearch(Builder $query, Request $request)
    {
        $query->whereTranslationLike('name', "%$request->name%");

        if ($request->has('transactions_count') || $request->has('transaction_status')) {
            $query->where(function ($q) use ($request) {
                $q->selectRaw('COUNT(*) as transaction_count')
                    ->from('transactions')
                    ->where('banks.id', 'transactions.bank_id')
                    ->where('transactions.status', $request->transaction_status);
            }, $request->transactions_count);
        }
    }
    #endregion scopes

    #region relationships
    public function branches(): HasMany
    {
        return $this->hasMany(BankBranch::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }
    #endregion relationships

    #region custom Methods
    #endregion custom Methods
}
