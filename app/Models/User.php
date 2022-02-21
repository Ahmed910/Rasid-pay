<?php

namespace App\Models;

use App\Traits\Uuid;
use App\Models\Role\Role;
use App\Traits\HasAssetsTrait;
use App\Models\Country\Country;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Sanctum\HasApiTokens;
use App\Contracts\HasAssetsInterface;
use App\Traits\Loggable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements HasAssetsInterface
{
    use HasApiTokens, HasFactory, Notifiable, Uuid, SoftDeletes, HasAssetsTrait, Loggable;

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
            if ($this->role->permissions->contains('name', $route . ".index")) {
                return true;
            } elseif ($this->role->permissions->contains('name', $route . ".store")) {
                return true;
            } elseif ($this->role->permissions->contains('name', $route . ".update")) {
                return true;
            } elseif ($this->role->permissions->contains('name', $route . ".read")) {
                return true;
            } elseif ($this->role->permissions->contains('name', $route . ".show")) {
                return true;
            } elseif ($this->role->permissions->contains('name', $route . ".archive")) {
                return true;
            } elseif ($this->role->permissions->contains('name', $route . ".restore")) {
                return true;
            } elseif ($this->role->permissions->contains('name', $route . ".force_delete")) {
                return true;
            }
        } elseif (is_array($method)) {
            $arr = substr_replace($method, $route . '.', 0, 0);
            return $this->role->permissions->search(function ($item) use ($arr) {
                return in_array(@$item->name, $arr);
            });
        } else {
            return $this->role->permissions->contains('name', $route . "." . $method);
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

    public function scopeSearch(Builder $query, $request)
    {
        if (isset($request->fullname)) {
            $query->where("fullname", "like", "%$request->fullname%");
        }
        
        if (isset($request->created_at)) {

            $query->whereDate('created_at', $request->created_at);
        }

        if (isset($request->client_type)) {
            $query->where("client_type", $request->client_type);
        }

        if (isset($request->country_id)) {
            $query->where('country_id', $request->country);
        }
        if (isset($request->is_ban)) {
            $query->where('is_ban', $request->is_ban);
        }
        if (isset($request->register_status)) {
            $query->where('register_status', $request->register_status);
        }
        if (isset($request->gender)) {
            $query->where('gender', $request->gender);
        }
        if (isset($request->is_active)) {
            $query->where('is_active', $request->is_active);
        }
    }


}
