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
//    public $sortableColumns = ["client_type", "marital_status", "nationality", "address", "activity_type"];

    #endregion properties

    #region mutators
    #endregion mutators

    #region scopes

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
        return $this->hasOne(BankAccount::class,'user_id','user_id');
    }

    #endregion relationships

    #region custom Methods
    #endregion custom Methods
}
