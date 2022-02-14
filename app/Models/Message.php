<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    use HasFactory, Uuid;
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
    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function reciever(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    #endregion relationships

    #region custom Methods
    #endregion custom Methods
}
