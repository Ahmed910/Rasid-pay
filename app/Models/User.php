<?php

namespace App\Models;

use App\Models\Role\Role;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Uuid;

    protected $guarded = ['created_at','updated_at','deleted_at'];
    // protected $appends = ['avatar','image' , 'name'];
    protected $hidden = ['password', 'remember_token'];
    protected $casts = ['email_verified_at' => 'datetime' , 'phone_verified_at' => 'datetime'];
    protected $dates = ['date_of_birth' , 'date_of_birth_hijri'];

    public function setPasswordAttribute($value)
    {
        if ($value) {
            $this->attributes['password'] = bcrypt($value);
        }
    }


     // Roles & Permissions
     public function role(): HasOne
     {
         return $this->hasOne(Role::class);
     }

     public function hasPermissions($route, $method = null)
     {
         if ($this->user_type == 'superadmin') {
              return true;
         }
         if (is_null($method)) {
                if ($this->role->permissions->contains('route_name',$route.".index")) {
                    return true;
                }elseif ($this->role->permissions->contains('route_name',$route.".store")) {
                    return true;
                }elseif ($this->role->permissions->contains('route_name',$route.".update")) {
                    return true;
                }elseif ($this->role->permissions->contains('route_name',$route.".destroy")) {
                    return true;
                }elseif ($this->role->permissions->contains('route_name',$route.".show")) {
                    return true;
                }elseif ($this->role->permissions->contains('route_name',$route.".wallet")) {
                    return true;
                }
            }else{
                 return $this->role->permissions->contains('route_name',$route.".".$method);
            }
            return false;
     }

}
