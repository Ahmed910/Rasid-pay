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
    public function getCreatedAtMobileAttribute($date)
    {
        $locale = app()->getLocale();
        if (auth()->check() && auth()->user()->is_date_hijri) {
            $this->changeDateLocale($locale);
            return Hijri::convertToHijri($this->attributes['created_at'])->format('d F o h:i A');
        }
        return Carbon::parse($this->attributes['created_at'])->locale($locale)->translatedFormat('Y/m/d - h:i A');
    }
    #endregion mutators

    #region scopes
    #endregion scopes

    #region relationships
    public function citizen(): BelongsTo
    {
        return $this->belongsTo(Citizen::class, 'citizen_id');
    }

    public function transaction()
    {
        return $this->morphOne(Transaction::class, "transactionable");
    }
    #endregion relationships

    #region custom Methods
    #endregion custom Methods
}
