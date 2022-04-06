<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manager extends Model
{
    use HasFactory, Uuid;

    #region properties
    protected $guarded = ['created_at', 'updated_at'];
    protected $dates = ['date_of_birth'];
    #endregion properties

    #region mutators
    public function setManagerPhoneAttribute($value)
    {
        $value = $value[0] == "0" ? substr($value, 1) : $value;
        $this->attributes['manager_phone'] = isset($this->attributes['manager_country_code']) ? $this->attributes['manager_country_code'] . $value : $value;

    }
    #endregion mutators

    #region scopes
    #endregion scopes

    #region relationships
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    #endregion relationships

    #region custom Methods
    #endregion custom Methods
}
