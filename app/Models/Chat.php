<?php

namespace App\Models;

use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuid;

class Chat extends Model
{
    use HasFactory, SoftDeletes, Uuid, Loggable;

    #region properties
    protected $guarded = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts = ['read_at' => 'datetime'];
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
        return $this->belongsTo(User::class, 'sender_id', 'id');
    }

    public function reciever()
    {
        return $this->belongsTo(User::class, 'reciever_id', 'id');
    }
    #endregion relationships

    #region custom Methods
    #endregion custom Methods

}
