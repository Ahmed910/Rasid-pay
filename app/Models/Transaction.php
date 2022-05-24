<?php

namespace App\Models;

use App\Models\Bank\Bank;
use App\Models\CardPackage\CardPackage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Loggable;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Transaction extends Model
{

    use HasFactory, Uuid, Loggable, SoftDeletes;

    protected $guarded = ['number', 'created_at', 'updated_at'];
    private $sortableColumns = ["user_from", "number", "created_at", "user_identity", 'from_user_to', 'amount', 'total_amount', 'gift_balance', 'type', 'status', 'discount_percent'];
    const user_searchable_Columns = ["user_from", "email", "image", "country_code", "phone", "full_phone", "identity_number", "date_of_birth"];
    const user_sortable_Columns = ["user_from" => "fullname", "email" => "email", "image" => "email", "country_code" => "country_code", "phone" => "phone", "full_phone" => "full_phone", "identity_number" => "identity_number", "date_of_birth" => "date_of_birth"];
    const SELECT_ALL = ["enabled_card"];
    const transaction_searchable_Columns = ["transaction_number", "user_identity",  "transaction_type", "transaction_status"];
    const ENABLED_CARD_SEARCHABLE_COLUMNS = ["enabled_card" => "card_type"];
    const client_searchable_Columns = ["user_to", "client_type", "commercial_number", "nationality", "tax_number", "transactions_done"];
    const client_sortable_Columns = ["user_to" => "fullname", "client_type" => "client_type", "commercial_number" => "commercial_number", "nationality" => "nationality", "tax_number" => "tax_number", "transactions_done" => "transactions_done"];
    const ENABLED_CARD_sortable_COLUMNS = ["enabled_card" => "card_type"];

    public static function boot()
    {
        parent::boot();
        static::created(function ($item) {
            $qr_code = self::createQr($item->id);
            $item->update(['qr_code' => $qr_code]);
        });
    }

    private static function createQr($qr_value)
    {
        self::checkOrCreateQrDirectory();
        $filname = time() . "_" . $qr_value . "_qr_code.png";

        $path = storage_path('app/public/images/transactions/' . $filname);


        \QrCode::errorCorrection('H')
            ->format('png')
            ->encoding('UTF-8')
            ->merge(public_path('dashboardAssets/images/brand/logoQR.png'), .2, true)
            ->size(500)
            ->generate($qr_value, $path);
        return 'images/transactions/' . $filname;
    }

    private static function checkOrCreateQrDirectory()
    {
        if (!\File::isDirectory(storage_path('app/public/images/transactions/'))) {
            \File::makeDirectory(storage_path('app/public' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'transactions' . DIRECTORY_SEPARATOR), 0777, true);
        }
    }

    public function scopeSearch(Builder $query, $request)
    {
        $old = $query->toSql() ;
        foreach ($request->all() as $key => $item) {
            if ($item == -1 && in_array($key, self::SELECT_ALL)) $request->request->remove($key);
            if (key_exists($key, self::ENABLED_CARD_SEARCHABLE_COLUMNS) && isset($request->$key))
                $query->whereHas(
                    'citizen.citizen.enabledCard',
                    function ($q) use ($key, $item) {
                        $q->where(self::ENABLED_CARD_SEARCHABLE_COLUMNS[$key], $item);
                    }
                );
        }
        if (isset($request->transaction_number)) {
            $query->where('number', 'like', "%$request->transaction_number%");
        }

        if (isset($request->user_identity)) {
            $query->where("user_identity", 'like', "%$request->user_identity%");
        }

        if (isset($request->status)) {
            if ($request->status == 0) $request->status = null;
            if ($request->status != -1) $query->where("status", $request->status);
        }

        if (isset($request->type)) {
            if ($request->type == 0) $request->type = null;
            if ($request->type != -1) $query->where("type", $request->type);
        }

        if (isset($request->transaction_value_from)) {
            $query->where("amount", '<=', $request->transaction_value_from);
        }
        if (isset($request->transaction_value_to)) {
            $query->where("amount", '>=', $request->transaction_value_to);
        }
        if (isset($request->card_package_id)) {
            if ($request->card_package_id == 0) $request->card_package_id = null;
            if ($request->card_package_id != -1) $query->whereHas('card', fn ($q) => $q->where('id', $request->card_package_id));
        }
        if (isset($request->client)) {
            if ($request->client == 0) $request->client = null;
            if ($request->client != -1) {
                $query->whereHas('client', function ($query) use ($request) {
                    $query->where('user_id', $request->client);
                });
            }
        }

        if (isset($request->citizen)) {
            $query->whereHas('citizen', fn ($q) => $q->where('fullname', 'like', "%$request->citizen%"));
        }

        $new = $query->toSql() ;
        if ($old!=$new)  $this->addGlobalActivity($this, $request->query(), ActivityLog::SEARCH, 'index');
        // if (isset($request->card_type)) {
        //     $query->whereHas('citizen.citizen.enabledCard',
        //      fn($q) => $q->where('card_type', $request->card_type));
        // }
    }

    public function scopeSortBy(Builder $query, $request)
    {
        if (!isset($request->sort["column"]) || !isset($request->sort["dir"])) return $query->latest('transactions.created_at');

        if (
            //  !in_array(Str::lower($request->sort["column"]), $this->sortableColumns) ||
            !in_array(Str::lower($request->sort["dir"]), ["asc", "desc"])
        ) {
            return $query->latest('transactions.created_at');
        } else if (in_array($request->sort["column"], self::transaction_searchable_Columns)) {

            return $query
                ->orderBy($request->sort["column"], @$request->sort["dir"]);
        } else if (in_array($request->sort["column"], self::user_searchable_Columns)) {

            return $query->join('users', 'users.id', '=', 'transactions.from_user_id')
                ->orderBy('users.' . self::user_sortable_Columns[$request->sort["column"]], @$request->sort["dir"]);
        } else if (key_exists($request->sort["column"], self::client_sortable_Columns)) {
            return $query->join('users', 'users.id', '=', 'transactions.to_user_id')
                ->orderBy('users.' . self::client_sortable_Columns[$request->sort["column"]], @$request->sort["dir"]);
        } else
        if (key_exists($request->sort["column"], self::ENABLED_CARD_sortable_COLUMNS)) {
            return
                $query
                ->leftjoin("citizen_cards", 'citizen_cards.citizen_id', '=', 'transactions.from_user_id')
                ->orderBy('citizen_cards.' . self::ENABLED_CARD_sortable_COLUMNS[$request->sort["column"]], @$request->sort["dir"]);
        }


        $query->when($request->sort, function ($q) use ($request) {
            $q->orderBy($request->sort["column"], @$request->sort["dir"]);
        });
    }

    public function card(): BelongsTo
    {
        return $this->belongsTo(CardPackage::class, 'card_package_id');
    }

    public function citizen(): BelongsTo
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(User::class, 'to_user_id');
    }

    public function bank(): BelongsTo
    {
        return $this->belongsTo(Bank::class, 'bank_id');
    }
}
