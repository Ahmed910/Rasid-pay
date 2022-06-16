<?php

namespace App\Models;

use App\Traits\Loggable;
use App\Traits\Uuid;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Client extends Model
{
    use HasFactory, Uuid, Loggable;

    #region properties
    protected $guarded = ['created_at', 'updated_at'];
    protected $dates = ['date_of_birth'];
    public $sortableColumns = ["transactions_done", "client_type", "marital_status", "nationality", "address", "activity_type", "fullname", "commercial_number", "tax_number", "client_type", "bank_name"];
    const user_searchable_Columns = ["fullname", "email", "image", "country_code", "phone", "full_phone", "identity_number", "date_of_birth"];
    const client_searchable_Columns = ["client_type", "commercial_number", "nationality", "tax_number", "transactions_done"];
    const bank_sort_Columns = ["bank_name" => "name"];
    const bank_acc_sort_Columns = ["account_status" => "user.bankAccount.account_status"];
    const CLIENT_TYPES = ["institution" => "مؤسسات", "member" => "عضو", "company" => "شركات", "freelance_doc" => "مستقل", "famous" => "مشاهير", "other" => "اخرى"];
    const SELECT_ALL = ["client_type", "account_status", "bank_name", "bank_id"];

    #endregion properties

    #region mutators
    #endregion mutators

    #region scopes
    public function scopeSearch($query, $request)
    {
        $old = $query->toSql() ;
        foreach ($request->all() as $key => $item) {
            if ($item == -1 && in_array($key, self::SELECT_ALL)) $request->request->remove($key);

            if (in_array($key, self::user_searchable_Columns))
                $query->whereHas('user', function ($q) use ($key, $item) {
                    !$key == "fullname" ? $q->where($key, $item) : $q->where($key, "like", "%$item%");
                });
        }
        foreach ($request->all() as $key => $item) {
            if (in_array($key, self::client_searchable_Columns))
                $query->where($key, $item);
        }
        if ($request->trans_count_from) $query->where("transactions_done", ">=", $request->trans_count_from);

        if ($request->trans_count_to) $query->where("transactions_done", "<=", $request->trans_count_to);

        if ($request->created_from || $request->created_to) {
            $query->wherehas("user.clientTransactions", function ($q) use ($request) {
                $q->where("status", "success")->CustomDateFromTo($request);
            });
        }


        if ($request->bank_id) $query->whereHas("bankAccount", function ($q) use ($request) {
            $q->where('bank_id', $request->bank_id);
        });

        if ($request->account_status) $query->whereHas("bankAccount", function ($q) use ($request) {
            $q->where('account_status', $request->account_status);
        });
        $new = $query->toSql() ;
        if ($old!=$new)  $this->addGlobalActivity($this, $request->query(), ActivityLog::SEARCH, 'index');
    }

    public function scopeSortBy(Builder $query, $request)
    {
        if (!isset($request->sort["column"]) || !isset($request->sort["dir"])) return $query->latest('clients.created_at');

        if (
//            !in_array(Str::lower($request->sort["column"]), $this->sortableColumns) ||
        !in_array(Str::lower($request->sort["dir"]), ["asc", "desc"])
        ) {
            return $query->latest('clients.created_at');
        }
        if (in_array($request->sort["column"], self::client_searchable_Columns)) {

            return $query
                ->orderBy($request->sort["column"], @$request->sort["dir"]);
        } else {
            if (in_array($request->sort["column"], self::user_searchable_Columns)) {
                return $query->join('users', 'users.id', '=', 'clients.user_id')
                    ->orderBy('users.' . $request->sort["column"], @$request->sort["dir"]);
            } else if (key_exists($request->sort["column"], self::bank_acc_sort_Columns)) {
                return $query->join('bank_accounts', 'bank_accounts.user_id', '=', 'clients.user_id')
                    ->orderBy('bank_accounts.' . $request->sort["column"], @$request->sort["dir"]);
            } else if (key_exists($request->sort["column"], self::bank_sort_Columns)) {
                return $query->join('bank_accounts', 'bank_accounts.user_id', '=', 'clients.user_id')
                    ->leftjoin('banks', 'banks.id', '=', 'bank_accounts.bank_id')
                    ->leftjoin('bank_translations', 'banks.id', '=', 'bank_translations.bank_id')
                    ->orderBy('bank_translations.' . self::bank_sort_Columns[$request->sort["column"]], @$request->sort["dir"]);
            }
        }
    }
    #endregion scopes

    #region relationships
    public function managers()
    {
        return $this->hasMany(Manager::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bankAccount()
    {
        return $this->hasOne(BankAccount::class, 'user_id', 'user_id');
    }

    #endregion relationships

    #region custom Methods
    #endregion custom Methods
}
