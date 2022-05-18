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
use GeniusTS\HijriDate\Hijri;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\ResetPasswordNotification;
use Carbon\Carbon;
use Illuminate\Support\Str;

class User extends Authenticatable implements HasAssetsInterface
{
    use HasApiTokens, HasFactory, Notifiable, Uuid, SoftDeletes, HasAssetsTrait, Loggable;

    protected $guarded = ['created_at', 'deleted_at'];
    protected $appends = ['image'];
    protected $hidden = ['password', 'remember_token'];
    protected $casts = ['email_verified_at' => 'datetime', 'phone_verified_at' => 'datetime'];
    protected $dates = ['date_of_birth', 'date_of_birth_hijri'];
    public $assets = ['image'];
    protected $with = ['images'];
    private $sortableColumns = ["login_id", "created_at", "fullname", "department", 'ban_status'];

    public static function boot()
    {
        parent::boot();
        static::saved(function ($model) {
            $model->saveAssets($model, request());
        });
    }

    public function setPhoneAttribute($value)
    {
        if (isset($value)) $value = $value[0] == "0" ? substr($value, 1) : $value;
        $this->attributes['phone'] = isset($this->attributes['country_code']) ? $this->attributes['country_code'] . $value : $value;
    }

    public function setPasswordAttribute($value)
    {
        if ($value) {
            $this->attributes['password'] = bcrypt($value);
        }
    }

    public function getDateOfBirthAttribute($date)
    {
        if (auth()->check() && auth()->user()->is_date_hijri) {
            return Hijri::convertToHijri($date)->format('d F o');
        }
        return date('Y-m-d', strtotime($date));
    }

    public function getDateOfBirthHijriAttribute($date)
    {

        if (auth()->check() && auth()->user()->is_date_hijri) {
            return Hijri::convertToHijri($date)->format('d F o');
        }
        return date('Y-m-d', strtotime($date));
    }

    public function getImageAttribute()
    {
        return asset($this->images()->first()?->media) ?? 'https://picsum.photos/200';
    }

    public function getPermissionListAttribute()
    {
        return $this->permissions->pluck('id')->toArray();
    }


    public function getGroupListAttribute()
    {
        return $this->groups->pluck('id')->toArray();
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
        return $this->hasOneThrough(Department::class, Employee::class, 'user_id', 'id', 'id', 'department_id');
    }

    public function client()
    {
        return $this->hasOne(Client::class);
    }
    public function citizen()
    {
        return $this->hasOne(Citizen::class);
    }

    public function admin()
    {
        return $this->hasOne(Admin::class);
    }

    public function bankAccount()
    {
        return $this->hasOne(BankAccount::class);
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }

    public function citizenWallet()
    {
        return $this->hasOne(CitizenWallet::class);
    }
    public function clientTransactions()
    {
        return $this->hasMany(Transaction::class, 'to_user_id');
    }
    public function citizenTransactions()
    {
        return $this->hasMany(Transaction::class, 'from_user_id');
    }

    public function citizenCards()
    {
        return $this->hasMany(CitizenCard::class, 'citizen_id', 'id');
    }

    public function setBanStatusAttribute($value)
    {
        $this->attributes['ban_status'] = $value;
        if ($value != 'temporary') {
            $this->attributes['ban_from'] = null;
            $this->attributes['ban_to'] = null;
        }
    }

    public function getBanFromAttribute($value)
    {
        if ($value == null) return;

        if (auth()->check() && auth()->user()->is_date_hijri) {
            $this->changeDateLocale('en');

            return Hijri::convertToHijri($value)->format('Y-m-d');
        }

        return Carbon::parse($value)->format('Y-m-d');
    }

    public function getBanToAttribute($value)
    {
        if ($value == null) return;

        if (auth()->check() && auth()->user()->is_date_hijri) {
            $this->changeDateLocale('en');

            return Hijri::convertToHijri($value)->format('Y-m-d');
        }

        return Carbon::parse($value)->format('Y-m-d');
    }

    #region scopes
    public function scopeSearch(Builder $query, $request)
    {
        $this->addGlobalActivity($this, $request->query(), ActivityLog::SEARCH, 'index');
        if (isset($request->name)) {
            $query->where(function ($q) use ($request) {
                $q->where("fullname", "like", "%\\$request->name%");
            });
        }

        !$request->client_type ?: $query->where("client_type", $request->client_type);
        !$request->country_id ?: $query->where("country_id", $request->country_id);

        if (isset($request->login_id)) {
            $query->where("login_id", "like", "%$request->login_id%");
        }

        if (isset($request->ban_status)) {
            if (!in_array($request->ban_status, ['active', 'permanent', 'temporary'])) return;

            $query->where('ban_status', $request->ban_status);
        }

        !$request->register_status ?: $query->where("register_status", $request->register_status);
        !$request->login_id ?: $query->where("login_id", "like", "%$request->login_id%");

        if ($request->department_id > 0) {
            $query->whereHas('department', function ($query) use ($request) {
                $query->where('departments.id', $request->department_id);
            });
        }

        if ($request->ban_from) {
            $ban_from = date('Y-m-d', strtotime($request->ban_from));
            if (auth()->user()->is_date_hijri == 1) {
                $date = explode("-", $ban_from);
                $ban_from = Hijri::convertToGregorian($date[2], $date[1], $date[0])->format('Y-m-d');
            }
            $query->whereDate('ban_from', "<=", $ban_from);
        }

        if ($request->ban_to) {
            $ban_to = date('Y-m-d', strtotime($request->ban_to));
            if (auth()->user()->is_date_hijri == 1) {
                $date = explode("-", $ban_to);
                $ban_to = Hijri::convertToGregorian($date[2], $date[1], $date[0])->format('Y-m-d');
            }
            $query->whereDate('ban_to', ">=", $ban_to);
        }
    }

    public function scopeSortBy(Builder $query, $request)
    {
        if (!isset($request->sort["column"]) || !isset($request->sort["dir"])) return $query->latest('created_at');

        if (
            !in_array(Str::lower($request->sort["column"]), $this->sortableColumns) ||
            !in_array(Str::lower($request->sort["dir"]), ["asc", "desc"])
        ) {
            return $query->latest('created_at');
        }

        $query->when($request->sort, function ($q) use ($request) {
            if ($request->sort['column'] == 'department') {
                return;
                //     return $q->leftJoin('employees', 'users.id', 'employees.user_id')
                //         ->leftJoin('departments', 'departments.id', 'employees.department_id')
                //         ->leftJoin('department_translations as trans', 'trans.department_id', 'departments.id')
                //         ->orderBy('trans.name');
            }

            $q->orderBy($request->sort["column"], @$request->sort["dir"]);
        });
    }

    #endregion scopes

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }
}
