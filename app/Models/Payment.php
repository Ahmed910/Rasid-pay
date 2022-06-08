<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\Uuid;

class Payment extends Model
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
    public function citizen(): BelongsTo
    {
        return $this->belongsTo(Citizen::class, 'citizen_id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
    #endregion relationships

    #region custom Methods
    #endregion custom Methods
}
