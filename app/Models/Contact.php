<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contact extends Model
{
    use HasFactory, Uuid, SoftDeletes;

    #region properties
    protected $guarded = ['created_at', 'updated_at', 'deleted_at'];
    #endregion properties

    #region mutators
    public function getReadAtAttribute($date)
    {
        return date('Y-m-d h:i A', strtotime($date));
    }

    public function setTitleAttribute($value)
    {
        if (auth('sanctum')->check()) {
            $this->attributes['fullname'] = auth('sanctum')->user()->fullname;
            $this->attributes['user_id'] = auth('sanctum')->id();
            $this->attributes['email'] = auth('sanctum')->user()->email;
            $this->attributes['phone'] = auth('sanctum')->user()->phone;
        }

        $this->attributes['title'] = $value;
    }
    #endregion mutators

    #region scopes
    #endregion scopes

    #region relationships
    public function replies(): HasMany
    {
        return $this->hasMany(ContactReply::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
    #endregion relationships

    #region custom Methods
    #endregion custom Methods
}
