<?php

namespace App\Models;

use App\Traits\Uuid;
use App\Models\Country\Country;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Models\RecieveOption\RecieveOption;
use App\Models\TransferRelation\TransferRelation;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Beneficiary extends Model
{
    use HasFactory, Uuid;

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
    public function scopeSearch(Builder $query, $request)
    {
        if ($request->has("name"))
            $query->where("name", "like", "%$request->name%");

        if ($request->has("benficiar_type"))
            $query->where("benficiar_type", $request->benficiar_type);
    }
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

    public function bankTransfers()
    {
        return $this->hasMany(BankTransfer::class);
    }

    public function recieveOption(): BelongsTo
    {
        return $this->belongsTo(RecieveOption::class);
    }

    public function transferRelation()
    {
        return $this->belongsTo(TransferRelation::class);
    }

    public function nationality()
    {
        return $this->belongsTo(Country::class, 'nationality_id');
    }
    #endregion relationships

    #region custom Methods
    #endregion custom Methods
}
