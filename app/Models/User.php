<?php

namespace App\Models;

use App\Traits\Uuid;
use App\Models\Role\Role;
use App\Traits\HasAssetsTrait;
use App\Models\Country\Country;
use Laravel\Sanctum\HasApiTokens;
use App\Contracts\HasAssetsInterface;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements HasAssetsInterface
{
    use HasApiTokens, HasFactory, Notifiable, Uuid, SoftDeletes, HasAssetsTrait;

    protected $guarded = ['created_at', 'updated_at', 'deleted_at'];
    // protected $appends = ['avatar','image' , 'name'];
    protected $hidden = ['password', 'remember_token'];
    protected $casts = ['email_verified_at' => 'datetime', 'phone_verified_at' => 'datetime'];
    protected $dates = ['date_of_birth', 'date_of_birth_hijri'];
    public $assets = ['image'];
    protected $with = ['images'];

    public static function boot()
    {
        parent::boot();
        static::saved(function ($model) {
            $model->saveAssets($model, request());
        });
    }

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
    public function devices()
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

    public function media()
    {
        return $this->morphOne(AppMedia::class, 'mediable');
    }

    public function addedBy()
    {
        return $this->belongsTo(User::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
