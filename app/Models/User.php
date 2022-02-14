<?php

namespace App\Models;

use App\Models\Country\Country;
use App\Models\Role\Role;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\Sanctum;

class User extends Authenticatable
{
    use HasApiTokens, SoftDeletes, HasFactory, Notifiable, Uuid;

    protected $guarded = ['created_at', 'updated_at', 'deleted_at'];
    // protected $appends = ['avatar','image' , 'name'];
    protected $hidden = ['password', 'remember_token'];
    protected $casts = ['email_verified_at' => 'datetime', 'phone_verified_at' => 'datetime'];
    protected $dates = ['date_of_birth', 'date_of_birth_hijri'];

    public function setPasswordAttribute($value)
    {
        if ($value) {
            $this->attributes['password'] = bcrypt($value);
        }
    }

    public function getDateOfBirthAttribute($date)
    {
        return date('Y-m-d', strtotime($date));
    }

    public function getDateOfBirthHijriAttribute($date)
    {
        return date('Y-m-d', strtotime($date));
    }

    // Roles & Permissions
    public function devices(): HasMany
    {
        return $this->hasMany(Device::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function hasPermissions($route, $method = null)
    {
        if ($this->user_type == 'superadmin') {
            return true;
        }
        if (is_null($method)) {
            if ($this->role->permissions->contains('route_name', $route . ".index")) {
                return true;
            } elseif ($this->role->permissions->contains('route_name', $route . ".store")) {
                return true;
            } elseif ($this->role->permissions->contains('route_name', $route . ".update")) {
                return true;
            } elseif ($this->role->permissions->contains('route_name', $route . ".destroy")) {
                return true;
            } elseif ($this->role->permissions->contains('route_name', $route . ".show")) {
                return true;
            } elseif ($this->role->permissions->contains('route_name', $route . ".wallet")) {
                return true;
            }
        } else {
            return $this->role->permissions->contains('route_name', $route . "." . $method);
        }
        return false;
    }

    public function media(): MorphOne
    {
        return $this->morphOne(AppMedia::class, 'mediable');
    }

    public function addedBy(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
}
