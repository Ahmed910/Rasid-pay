<?php

namespace App\Models;

use App\Traits\Loggable;
use App\Traits\Uuid;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Client extends Model
{
    use HasFactory, Uuid,Loggable;

    #region properties
    protected $guarded = ['created_at', 'updated_at'];
    protected $dates = ['date_of_birth'];
    public $sortableColumns = ["client_type", "marital_status", "nationality", "address", "activity_type"];
    const user_searchable_Columns = ["fullname", "email", "image", "country_code", "phone", "full_phone", "identity_number", "date_of_birth"];

    #endregion properties

    #region mutators
    #endregion mutators

    #region scopes
    public function scopeSearch($query, $request)
    {
//        $query->whereHas('user', function ($q) use ($request) {
//            $q->search($request);
//        });
        foreach ($request->all() as $key => $item) {
            if (in_array($key, self::user_searchable_Columns))
                $query->whereHas('user', function ($q) use ($key, $item) {
                    !$key == "fullname" ? $q->where($key, $item) : $q->where($key, "like", "%$item%");
                });
        }
        if ($request->client_type) $query->where("client_type", $request->client_type);
        if ($request->nationality) $query->where("nationality", $request->nationality);
        if ($request->bank_id) $query->whereHas("bankAccount", function ($q) use ($request) {
            $q->where('bank_id', $request->bank_id);
        });
    }

    public function scopeSortBy(Builder $query, $request)
    {
        if (!isset($request->sort["column"]) || !isset($request->sort["dir"])) return $query->latest('clients.created_at');

        if (
            !in_array(Str::lower($request->sort["column"]), $this->sortableColumns) ||
            !in_array(Str::lower($request->sort["dir"]), ["asc", "desc"])
        ) {
            return $query->latest('clients.created_at');
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
    public function managers()
    {
        return $this->hasMany(Manager::class);
    }

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
