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
    // protected $with = ['enabledCard'];

    protected $dates = ['date_of_birth'];
    const USER_SEARCHABLE_COLUMNS = ["fullname",  "country_code", "phone", "full_phone", "identity_number", "created_at"];
    const CITIZEN_SEARCHABLE_COLUMNS  = ["citizen_card_id"];
    const ENABLEDCARD_SEARCHABLE_COLUMNS = ["enabled_card" => "card_type"];
    const CARDPKG_SORT_COLUMNS = ["enabled_card" => "card_type"];
    const CITIZEN_CARDS_SORT_COLUMNS = ['card_end_at' => 'end_at'];
    const ENABLEDCARD_SORTABLE_COLUMNS = ["enabled_card" => "enabledCard.cardPackage", "card_end_at" => "enabledCard.end_at"];
    const SELECT_ALL = ["enabled_card" => "id"];
    #endregion properties

    #region mutators
    #endregion mutators

    #region scopes
    public function scopeSearch($query, $request)
    {
      
        foreach ($request->all() as $key => $item) {
            if ($item == -1 && in_array($key, self::SELECT_ALL)) $request->request->remove($key);
            if (key_exists($key, self::ENABLEDCARD_SEARCHABLE_COLUMNS))
                $query->whereHas('enabledCard', function ($q) use ($key, $item) {
                    $q->where(self::ENABLEDCARD_SEARCHABLE_COLUMNS[$key], $item);
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
            $query->wherehas("enabledCard", function ($q) use ($request) {
                $q->whereDate('end_at', ">=", $request->end_at_from);
            });
        }
        if ($request->end_at_to) {
            $query->wherehas("enabledCard", function ($q) use ($request) {
                $q->whereDate('end_at', "<=", $request->end_at_to);
            });
        }
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
            return $query->join('citizen_cards', 'citizen_cards.id', '=', 'citizens.Citizen_card_id')
                ->orderBy('citizen_cards.' . self::CARDPKG_SORT_COLUMNS[$request->sort["column"]], @$request->sort["dir"]);
        } else if (key_exists($request->sort["column"], self::CITIZEN_CARDS_SORT_COLUMNS)) {
            return $query->join('citizen_cards', 'citizen_cards.id', '=', 'citizens.Citizen_card_id')
                ->orderBy('citizen_cards.' . self::CITIZEN_CARDS_SORT_COLUMNS[$request->sort["column"]], @$request->sort["dir"]);
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


    public function enabledCard()
    {
        return $this->belongsTo(CitizenCard::class, 'citizen_card_id');
    }

    #endregion relationships

    #region custom Methods
    #endregion custom Methods
}
