<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Citizen extends Model
{
    use HasFactory, Uuid;

    #region properties
    protected $guarded = ['created_at', 'updated_at'];
    protected $dates = ['date_of_birth'];
    const user_searchable_Columns = ["fullname", "email", "image", "country_code", "phone", "full_phone", "identity_number", "date_of_birth"];
    const bank_account_searchable_Columns = ["iban_number", "contract_type", "bank_id",];


    #endregion properties

    #region mutators
    #endregion mutators

    #region scopes
    public function scopeSearch($query, $request)
    {
        foreach ($request->all() as $key => $item) {
            if (in_array($key, self::user_searchable_Columns))
                $query->whereHas('user', function ($q) use ($key, $item) {
                    !$key == "fullname" ? $q->where($key, $item) : $q->where($key, "like", "%$item%");
                });
            if (in_array($key, self::bank_account_searchable_Columns))
                $query->whereHas('bankAccount', function ($q) use ($key, $item) {
                    $q->where($key, $item);
                });
        }

//        if ($request->bank_id) $query->whereHas("bankAccount", function ($q) use ($request) {
//            $q->where('bank_id', $request->bank_id);
//        });
    }

    public function scopeSortBy(Builder $query, $request)
    {
        if (!isset($request->sort["column"]) || !isset($request->sort["dir"])) return $query->latest('citizens.created_at');

        if (
            !in_array(Str::lower($request->sort["column"]), $this->sortableColumns) ||
            !in_array(Str::lower($request->sort["dir"]), ["asc", "desc"])
        ) {
            return $query->latest('citizens.created_at');
        }


        $query->when($request->sort, function ($q) use ($request) {
            if ($request->sort["column"] == "name") {
                return $q->has('translations')
                    ->orderBy($request->sort["column"], @$request->sort["dir"]);
            }


            $q->orderBy($request->sort["column"], @$request->sort["dir"]);
        });
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

    #endregion relationships

    #region custom Methods
    #endregion custom Methods
}
