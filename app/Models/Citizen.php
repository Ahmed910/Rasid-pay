<?php

namespace App\Models;

use App\Traits\Loggable;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Citizen extends Model
{
    use HasFactory, Uuid, Loggable;

    #region properties
    protected $guarded = ['created_at', 'updated_at'];
    // protected $with = ['enabledPackage'];

    protected $dates = ['date_of_birth'];
    const USER_SEARCHABLE_COLUMNS = ["fullname",  "country_code", "phone", "identity_number", "created_at"];
    const CITIZEN_SEARCHABLE_COLUMNS  = ["citizen_package_id"];
    const ENABLEDPACKAGES_SEARCHABLE_COLUMNS = ["enabled_package" => "card_type"];
    const CARDPKG_SORT_COLUMNS = ["enabled_package" => "card_type"];
    const CITIZEN_PACKAGES_SORT_COLUMNS = ['card_end_at' => 'end_at'];
    const ENABLEDPACKAGES_SORTABLE_COLUMNS = ["enabled_package" => "enabledPackage.package", "card_end_at" => "enabledPackage.end_at"];
    const SELECT_ALL = ["enabled_package" => "id"];
    #endregion properties

    #region mutators
    #endregion mutators

    #region scopes
    public function scopeSearch($query, $request)
    {
        $old = $query->toSql() ;

        foreach ($request->all() as $key => $item) {
            if ($item == -1 && in_array($key, self::SELECT_ALL)) $request->request->remove($key);
            if (key_exists($key, self::ENABLEDPACKAGES_SEARCHABLE_COLUMNS))
                $query->whereHas('enabledPackage', function ($q) use ($key, $item) {
                    $q->where(self::ENABLEDPACKAGES_SEARCHABLE_COLUMNS[$key], $item);
                });
        }
        foreach ($request->all() as $key => $item) {
            if (in_array($key, self::USER_SEARCHABLE_COLUMNS))
                $query->whereHas('user', function ($q) use ($key, $item) {
                    !$key == "fullname" ? $q->where($key, $item) : $q->where($key, "like", "%$item%");
                });
        }

        if ($request->created_from || $request->created_to) {
            $query->CustomDateFromTo($request);
        }

        if ($request->end_at_from) {
            $query->wherehas("enabledPackage", function ($q) use ($request) {
                $q->whereDate('end_at', ">=", $request->end_at_from);
            });
        }
        if ($request->end_at_to) {
            $query->wherehas("enabledPackage", function ($q) use ($request) {
                $q->whereDate('end_at', "<=", $request->end_at_to);
            });
        }
        $new = $query->toSql() ;
        if ($old!=$new)  $this->addGlobalActivity($this, $request->query(), ActivityLog::SEARCH, 'index');
    }

    public function scopeSortBy(Builder $query, $request)
    {
        if (!isset($request->sort["column"]) || !isset($request->sort["dir"])) return $query->latest('citizens.created_at');

        if (!in_array(Str::lower($request->sort["dir"]), ["asc", "desc"])) {
            return $query->latest('citizens.created_at');
        }


        if (in_array($request->sort["column"], self::CITIZEN_SEARCHABLE_COLUMNS)) {
            return $query
                ->orderBy($request->sort["column"], @$request->sort["dir"]);
        } else if (in_array($request->sort["column"], self::USER_SEARCHABLE_COLUMNS)) {
            return $query->join('users', 'users.id', '=', 'citizens.user_id')
                ->orderBy('users.' . $request->sort["column"], @$request->sort["dir"]);
        } else if (key_exists($request->sort["column"], self::CARDPKG_SORT_COLUMNS)) {
            return $query->join('citizen_packages', 'citizen_packages.id', '=', 'citizens.citizen_package_id')
                ->orderBy('citizen_packages.' . self::CARDPKG_SORT_COLUMNS[$request->sort["column"]], @$request->sort["dir"]);
        } else if (key_exists($request->sort["column"], self::CITIZEN_PACKAGES_SORT_COLUMNS)) {
            return $query->join('citizen_packages', 'citizen_packages.id', '=', 'citizens.citizen_package_id')
                ->orderBy('citizen_packages.' . self::CITIZEN_PACKAGES_SORT_COLUMNS[$request->sort["column"]], @$request->sort["dir"]);
        }
    }
    #endregion scopes

    #region relationships
    public function user()
    {
        return $this->belongsTo(user::class);
    }

    public function bankAccount()
    {
        return $this->hasOne(BankAccount::class, 'user_id', 'user_id');
    }


    public function enabledPackage()
    {
        return $this->belongsTo(CitizenPackage::class, 'citizen_package_id');
    }

    public function payments(){

        return $this->hasMany(Payment::class);
    }

    #endregion relationships

    #region custom Methods
    #endregion custom Methods
}
