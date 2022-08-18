<?php

namespace App\Models;

use App\Contracts\HasAssetsInterface;
use App\Models\Country\Country;
use App\Models\Department\Department;
use App\Models\Faq\Faq;
use App\Models\Group\Group;
use App\Models\MessageType\MessageType;
use App\Models\RasidJob\RasidJob;
use App\Models\StaticPage\StaticPage;
use App\Notifications\ResetPasswordNotification;
use App\Traits\HasAssetsTrait;
use App\Traits\Loggable;
use App\Traits\Uuid;
use Carbon\Carbon;
use GeniusTS\HijriDate\Hijri;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements HasAssetsInterface
{
    use HasApiTokens, HasFactory, Notifiable, Uuid, SoftDeletes, HasAssetsTrait, Loggable;

    protected $guarded = ['created_at', 'deleted_at'];
    protected $appends = ['image'];
    protected $hidden = ['password', 'remember_token'];
    protected $casts = ['email_verified_at' => 'datetime', 'phone_verified_at' => 'datetime'];
    protected $dates = ['date_of_birth', 'date_of_birth_hijri', 'ban_from', 'ban_to'];
    public $assets = ['image'];
    protected $with = ['images', 'permissions'];
    private $sortableColumns = ["login_id", "created_at", "fullname", "department", 'ban_status', "basic_discount", "golden_discount", "platinum_discount", 'phone', 'email'];
    const CARDSORTABLECOLUMNS = ["basic_discount", "golden_discount", "platinum_discount"];

    public static function boot()
    {
        parent::boot();
        static::saved(function ($model) {
            $model->saveAssets($model, request());
        });
    }

    public function setPhoneAttribute($value)
    {
        // if (isset($value) && @$this->attributes['country_code'] == 966){
        //     $this->attributes['phone'] = $this->attributes['country_code'] . $value;
        // }else {
        $this->attributes['phone'] = filter_mobile_number($value);
        // }

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

    // public function getImageAttribute()
    // {
    //     return asset($this->images()->first()?->media) ?? 'https://picsum.photos/200';
    // }

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

    public function walletCharges()
    {
        return $this->hasMany(WalletCharge::class, 'citizen_id');
    }

    public function citizenWallet()
    {
        return $this->hasOne(CitizenWallet::class, 'citizen_id');
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

    public function userPermissions()
    {
        return $this->permissions()->doesntHave('groups')->orWhereHas('groups',function ($q) {
            $q->where('is_active', true);
        })->get();
    }

    public function hasPermissions($route, $method = null)
    {
        if ($this->user_type == 'superadmin') {
            return true;
        }
        $permissions = $this->userPermissions();
        dd($permissions);
        if (is_null($method) && $permissions) {
            // $route = str_replace(['create', 'edit'], ['store', 'update'], $route);
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
    public function staticPage()
    {
        return $this->hasMany(StaticPage::class);
    }

    public function faq()
    {
        return $this->hasMany(Faq::class);
    }
    public function department()
    {
        return $this->hasOneThrough(Department::class, Employee::class, 'user_id', 'id', 'id', 'department_id');
    }

    public function rasidJob()
    {
        return $this->hasOneThrough(RasidJob::class, Employee::class, 'user_id', 'id', 'id', 'rasid_job_id');
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

    public function clientTransactions()
    {
        return $this->hasMany(Transaction::class, 'to_user_id');
    }

    public function citizenTransactions()
    {
        return $this->hasMany(Transaction::class, 'from_user_id');
    }

    public function citizenPackages()
    {
        return $this->hasMany(CitizenPackage::class, 'citizen_id');
    }

    public function benficiaryTransfers()
    {
        return $this->hasMany(Beneficiary::class);
    }

    public function cards()
    {
        return $this->hasMany(Card::class, 'user_id');
    }
    public function phones()
    {
        return $this->hasMany(UserPhone::class, 'user_id');
    }

    public function messageTypes(): BelongsToMany
    {
        return $this->belongsToMany(MessageType::class, 'message_type_user', 'admin_id', 'message_type_id');
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

    public function isBanFromToday()
    {
        if (auth()->check() && auth()->user()->is_date_hijri) {
            $this->changeDateLocale('en');
            return Hijri::convertToHijri($this->attributes['ban_from'])->isToday();
        }
        return Carbon::parse($this->attributes['ban_from'])->isToday();
    }
    public function isBanToToday()
    {
        if (auth()->check() && auth()->user()->is_date_hijri) {
            $this->changeDateLocale('en');

            return Hijri::convertToHijri($this->attributes['ban_to'])->isToday();
        }
        return Carbon::parse($this->attributes['ban_to'])->isToday();
    }

    #region scopes
    public function scopeSearch(Builder $query, $request)
    {
        $old = $query->toSql();
        if (isset($request->name)) {
            $query->where(function ($q) use ($request) {
                $q->where("fullname", "like", "%\\$request->name%");
            });
        }

        if (isset($request->phone)) $query->where("phone", "like", "%$request->phone%");
        if (isset($request->email)) $query->where("email", "like", "%$request->email%");

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

        !$request->register_status ?: $query->where("register_status", $request->register_status);
        !$request->login_id ?: $query->where("login_id", "like", "%$request->login_id%");

        if ($request->department_id > 0) {
            $query->whereHas('department', function ($query) use ($request) {
                $query->where('departments.id', $request->department_id);
            });
        }

        if ($request->ban_from && $request->ban_status == 'temporary') {
            $ban_from = date('Y-m-d', strtotime($request->ban_from));
            if (auth()->user()->is_date_hijri == 1) {
                $date = explode("-", $ban_from);
                $ban_from = Hijri::convertToGregorian($date[2], $date[1], $date[0])->format('Y-m-d');
            }
            $query->whereDate('ban_from', "<=", $ban_from);
        }

        if ($request->ban_to && $request->ban_status == 'temporary') {
            $ban_to = date('Y-m-d', strtotime($request->ban_to));
            if (auth()->user()->is_date_hijri == 1) {
                $date = explode("-", $ban_to);
                $ban_to = Hijri::convertToGregorian($date[2], $date[1], $date[0])->format('Y-m-d');
            }
            $query->whereDate('ban_to', ">=", $ban_to);
        }

        if ($request->id && $request->id != "-1") {
            $query->where('users.id', $request->id);
        }

        if ($request->client_id && !in_array($request->client_id, [-1])) {
            $query->where('id', $request->client_id);
        }

        //NOTE: Should be the last one in search scope
        if (isset($request->ban_status)) {
            if (!in_array($request->ban_status, ['active', 'permanent', 'temporary'])) return;

            $query->where('ban_status', $request->ban_status);
        }

        $new = $query->toSql();
        if ($old != $new) Loggable::addGlobalActivity($this, array_merge($request->query(), ['department_id' => Department::find($request->department_id)?->name]), ActivityLog::SEARCH, 'index', request()->user_type);
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
                return $q->select(['users.*', "trans.name"])
                    ->Join('employees', 'users.id', 'employees.user_id')
                    ->leftJoin('department_translations as trans', 'trans.department_id', 'employees.department_id')
                    ->orderBy('trans.name', @$request->sort['dir'])->latest();
            } else   if (in_array($request['sort']['column'], self::CARDSORTABLECOLUMNS)) {
                return $q->Join('packages', 'users.id', 'packages.client_id')
                    ->select("users.*", "packages.basic_discount", "packages.golden_discount", "packages.platinum_discount")
                    ->distinct()
                    ->orderBy('packages.' . $request->sort['column'], @$request->sort['dir'])->latest();
            } else $q->orderBy($request->sort["column"], @$request->sort["dir"])->latest();
        });
    }

    #endregion scopes

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }
}
