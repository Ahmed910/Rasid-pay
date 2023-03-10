<?php

namespace App\Models;

use App\Traits\Loggable;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use GeniusTS\HijriDate\Hijri;

class Citizen extends Model
{
    use HasFactory, Uuid;

    #region properties
    protected $guarded = ['created_at', 'updated_at'];
    // protected $with = ['enabledPackage'];

    protected $dates = ['date_of_birth'];
    const USER_SEARCHABLE_COLUMNS = ["fullname", "phone", "identity_number"];
    const USER_SORTABLE_COLUMNS = ["fullname", "phone", "identity_number", 'ban_status'];
    const CARDPKG_SORT_COLUMNS = ["enabled_package" => "package_type", 'created_at' => 'start_at', 'card_end_at' => 'end_at'];
    const SELECT_ALL = ["enabled_package" => "id"];
    #endregion properties

    #region mutators
    #endregion mutators

    #region scopes
    public function scopeSearch($query, $request)
    {
        $old = $query->toSql();

        if ($request->enabled_package && !in_array(-1, $request->enabled_package)) {
            $query->whereHas(
                'user.citizen.enabledPackage',
                fn ($q) => $q->whereIn('package_type', $request->enabled_package)
            );
        }

        foreach ($request->all() as $key => $item) {
            if (in_array($key, self::USER_SEARCHABLE_COLUMNS))
                $query->whereHas('user', function ($q) use ($key, $item) {
                    $q->where($key, "like", "%$item%");
                    //                    !($key == "fullname") ? $q->where($key, $item) : $q->where($key, "like", "%$item%");
                });
        }

        if ($request->created_from || $request->created_to) {
            $query->customDateFromTo($request);
        }

        if ($request->end_at_from) {
            $endAtFrom = date('Y-m-d', strtotime($request->end_at_from));
            if (setting('rasid_date_type')) {
                $date = explode("-", $endAtFrom);
                $endAtFrom = Hijri::convertToGregorian($date[2], $date[1], $date[0])->format('Y-m-d');
            }

            $query->wherehas("enabledPackage", function ($q) use ($endAtFrom) {
                $q->whereDate('end_at', ">=", $endAtFrom);
            });
        }

        if ($request->end_at_to) {
            $endAtTo = date('Y-m-d', strtotime($request->end_at_to));
            if (setting('rasid_date_type')) {
                $date = explode("-", $endAtTo);
                $endAtTo = Hijri::convertToGregorian($date[2], $date[1], $date[0])->format('Y-m-d');
            }

            $query->wherehas("enabledPackage", function ($q) use ($request) {
                $q->whereDate('end_at', "<=", $request->end_at_to);
            });
        }

        if ($request->ban_status && $request->ban_status != -1) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('ban_status', $request->ban_status);
            });
        }

        $new = $query->toSql();
        if ($old != $new || $request->ban_status == -1)
            Loggable::addGlobalActivity($this, array_merge($request->query(),$this->searchParams($request)), ActivityLog::SEARCH, 'index');
    }

    public function scopeSortBy(Builder $query, $request)
    {
        if (!isset($request->sort["column"]) || !isset($request->sort["dir"])) return $query->latest('citizens.created_at');

        if (!in_array(Str::lower($request->sort["dir"]), ["asc", "desc"])) {
            return $query->latest('citizens.created_at');
        }

        if (in_array($request->sort["column"], self::USER_SORTABLE_COLUMNS)) {
            return $query->join('users', 'users.id', '=', 'citizens.user_id')
                ->orderBy('users.' . $request->sort["column"], @$request->sort["dir"])->latest('citizens.created_at');
        } else if (key_exists($request->sort["column"], self::CARDPKG_SORT_COLUMNS)) {
            return $query->join('citizen_packages', 'citizen_packages.id', '=', 'citizens.citizen_package_id')
                ->orderBy('citizen_packages.' . self::CARDPKG_SORT_COLUMNS[$request->sort["column"]], @$request->sort["dir"])->latest('citizens.created_at');
        }
    }
    #endregion scopes

    #region relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bankAccount()
    {
        return $this->hasOne(BankAccount::class, 'user_id', 'user_id');
    }

    public function enabledPackage()
    {
        return $this->belongsTo(CitizenPackage::class, 'citizen_package_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function citizenPackages()
    {
        return $this->hasMany(CitizenPackage::class, 'citizen_id');
    }

    #endregion relationships

    #region custom Methods
    private function searchParams($request){
        $searchParams = [];
        if($request->has('enabled_package')){
            $searchParams['enabled_package'] = trans_log_search($request->enabled_package,'dashboard.package_types.');
        }
        if($request->ban_status){
            $searchParams['ban_status'] = __('dashboard.admin.active_cases.'. $request->ban_status);
        }

        return $searchParams;
    }
    #endregion custom Methods
}
