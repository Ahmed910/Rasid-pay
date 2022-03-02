<?php

namespace App\Models;

use App\Traits\Uuid;
use App\Models\Group\Group;
use App\Traits\HasAssetsTrait;
use App\Models\Country\Country;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Sanctum\HasApiTokens;
use App\Contracts\HasAssetsInterface;
use App\Models\Department\Department;
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

    public function employee()
    {
        return $this->hasOne(Employee::class);
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class)->withTimestamps();
    }

    public function hasPermissions($route, $method = null)
    {
        if ($this->user_type == 'superadmin') {
            return true;
        }
        $permissions = $this->permissions;
        if (is_null($method) && $permissions) {
            return $permissions->contains('name', $route);
        } elseif (is_array($method) && $permissions) {
            $arr = substr_replace($method, $route . '.', 0, 0);
            return $permissions->search(function ($item) use ($arr) {
                return in_array(@$item->name, $arr);
            });
        } else {
            return $permissions->contains('name', $route . "." . $method);
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
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
    public function client()
    {
        return $this->hasOne(Client::class);
    }
    public function bankAccount()
    {
        return $this->hasOne(BankAccount::class);
    }

    public function setBanStatusAttribute($value)
    {
        $this->attributes['ban_status'] = $value;
        if ($value != 'temporary') {
            $this->attributes['ban_from'] = null;
            $this->attributes['ban_to'] = null;
        }
    }

    public function scopeSearch(Builder $query, $request)
    {
        if ($request->fullname) $query->where("fullname", "like", "%$request->fullname%");
        if ($request->created_at) $query->where("created_at", "like", "%$request->created_at%");
        if ($request->client_type) $query->where("client_type", "like", "%$request->client_type%");
        if ($request->country_id) $query->where("country_id", "like", "%$request->country_id%");
        if ($request->ban_status) $query->where("ban_status", "like", "%$request->ban_status%");
        if ($request->register_status) $query->where("register_status", "like", "%$request->register_status%");
        if ($request->gender) $query->where("gender", "like", "%$request->gender%");
        if ($request->is_active) $query->where("is_active", "like", "%$request->is_active%");
        if ($request->is_admin_active_user) $query->where("is_admin_active_user", "like", "%$request->is_admin_active_user%");
    }
}
