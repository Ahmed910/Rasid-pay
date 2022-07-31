<?php

namespace App\Models;

use App\Traits\Loggable;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Card extends Model
{
    use HasFactory, Uuid, Loggable, SoftDeletes;

    protected $guarded = ['created_at', 'updated_at'];
    protected $dates = ['expire_at'];

    #region properties
    #endregion properties

    #region mutators
    public function setExpireAtAttribute($value)
    {
        if ($value) {
            $this->attributes['expire_at'] = \Date::createFromFormat('m/y', $value);
        }
    }
    #endregion mutators

    #region scopes
    #endregion scopes

    #region relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    #endregion relationships


    #region custom Methods
    #endregion custom Methods
}
