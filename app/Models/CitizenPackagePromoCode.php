<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CitizenPackagePromoCode extends Model
{
    use HasFactory, Uuid;

    #region properties
    protected $guarded = ['created_at', 'updated_at'];

    #endregion properties

    public function scopeIsNotUsed($query)
    {
        return $query->where('is_used', false);
    }

    public function citizenPackage()
    {
        return $this->belongsTo(CitizenPackage::class);
    }
    #endregion relationships

    #region custom Methods
    #endregion custom Methods
}
