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
    private $sortableColumns = ["number", "created_at", "user_from", "user_identity", 'from_user_to', 'amount', 'total_amount', 'gift_balance', 'type', 'status', 'discount_percent'];
    const user_searchable_Columns = ["fullname", "email", "image", "country_code", "phone", "full_phone", "identity_number", "date_of_birth"];
    const transaction_searchable_Columns = ["transaction_number", "user_identity",  "transaction_type", "transaction_status"];

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
        $this->addGlobalActivity($this, $request->query(), ActivityLog::SEARCH, 'index');

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
            if ($request->card_package_id != -1) $query->whereHas('card', fn($q) => $q->where('id', $request->card_package_id));

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
            $query->whereHas('citizen', fn($q) => $q->where('fullname', 'like', "%$request->citizen%"));
        }
    }

    public function scopeSortBy(Builder $query, $request)
    {
        if (!isset($request->sort["column"]) || !isset($request->sort["dir"])) return $query->latest('transactions.created_at');

        if (
            !in_array(Str::lower($request->sort["column"]), $this->sortableColumns) ||
            !in_array(Str::lower($request->sort["dir"]), ["asc", "desc"])
        ) {
            return $query->latest('transactions.created_at');
        }
        if (in_array($request->sort["column"], self::transaction_searchable_Columns)) {

            return $query
                ->orderBy($request->sort["column"], @$request->sort["dir"]);
        } else {
            if (in_array($request->sort["column"], self::user_searchable_Columns)) {
                return $query->join('users', 'users.id', '=', 'transactions.from_user_id')
                    ->orderBy('users.' . $request->sort["column"], @$request->sort["dir"]);
            }
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
        return $this->belongsTo(Client::class, 'to_user_id');
    }

    public function bank(): BelongsTo
    {
        return $this->belongsTo(Bank::class, 'bank_id');
    }
}
