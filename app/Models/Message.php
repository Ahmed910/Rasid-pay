<?php

namespace App\Models;

use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;

class Message extends Model
{
    use HasFactory, Uuid, Loggable;
    #region properties
    protected $guarded = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts = ['last_messgae' => 'datetime', 'read_at' => 'datetime'];
    #endregion properties


    #region properties
    #endregion properties

    #region mutators
    #endregion mutators

    #region scopes
    #endregion scopes

    #region relationships
    public function sender()
    {
        return $this->belongsTo(User::class);
    }

    public function reciever()
    {
        return $this->belongsTo(User::class);
    }
    #endregion relationships

    #region custom Methods
    #endregion custom Methods
}
