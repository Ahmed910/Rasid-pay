<?php

namespace App\Models;

use Carbon\Carbon;
use App\Traits\Uuid;
use GeniusTS\HijriDate\Hijri;
use App\Models\Package\Package;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use phpDocumentor\Reflection\DocBlock\Tags\Deprecated;

class CitizenPackagePromoCode extends Model
{
    use HasFactory, Uuid;

    #region properties
    protected $guarded = ['created_at', 'updated_at'];

    #endregion properties

    public function citizenPackage()
    {
        return $this->belongsTo(CitizenPackage::class);
    }
    #endregion relationships

    #region custom Methods
    #endregion custom Methods
}
