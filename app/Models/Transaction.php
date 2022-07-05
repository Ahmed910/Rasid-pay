<?php

namespace App\Models;

use App\Models\Bank\Bank;
use App\Models\BankBranch\BankBranch;

//use App\Models\CardPackage\CardPackage;
use App\Models\Package\Package;
use Carbon\Carbon;
use GeniusTS\HijriDate\Hijri;
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

    const SUCCESS = 'success';
    const FAIL = 'fail';
    const PENDING = 'pending';
    const RECEIVED = 'received';
    const CANCELED = 'cancel';
    const TYPES = [
        self::SUCCESS,
        self::FAIL,
        self::PENDING,
        self::RECEIVED,
        self::CANCELED,
    ];

    protected $guarded = ['created_at', 'updated_at'];
    private $sortableColumns = ["user_from_id", "trans_number", "created_at", 'from_user_to', 'amount', 'fee_amount', 'trans_type', 'trans_status'];
    const USER_SEARCHABLE_COLUMNS = ["user_from", "email", "image", "country_code", "phone", "full_phone", "identity_number", "date_of_birth"];
    const USER_SORTABLE_COLUMNS = ["user_from" => "fullname", "email" => "email", "image" => "email", "country_code" => "country_code", "phone" => "phone", "full_phone" => "full_phone", "identity_number" => "identity_number", "date_of_birth" => "date_of_birth"];
    const SELECT_ALL = ["enabled_package", 'trans_status'];
    const TRANSACTION_SEARCHABLE_COLUMNS = ["trans_number", "user_identity", "transaction_type", "transaction_status"];
    const ENABLED_CARD_SEARCHABLE_COLUMNS = ["enabled_package" => "package_id"];
    const CLIENT_SORTABLE_COLUMNS = ["user_to" => "fullname", "client_type" => "client_type", "commercial_number" => "commercial_number", "nationality" => "nationality", "tax_number" => "tax_number", "transactions_done" => "transactions_done"];
    const ENABLED_CARD_sortable_COLUMNS = ["enabled_package" => "package_id"];
    const TRANSFERS = ['wallet_transfer', 'local_transfer', 'global_transfer'];
    const PAYMENTS = ['payment', 'promote_package'];
    const CHARGE = ['charge', 'money_request'];
    const TRANACTION_TYPES = ['wallet_transfer', 'local_transfer', 'global_transfer', 'payment', 'promote_package', 'charge', 'money_request'];

    public function scopeSearch(Builder $query, $request)
    {
        $old = $query->toSql();
        foreach ($request->all() as $key => $item) {
            if ($item == -1 && in_array($key, self::SELECT_ALL)) $request->request->remove($key);
            if (key_exists($key, self::ENABLED_CARD_SEARCHABLE_COLUMNS) && isset($request->$key) && !in_array(-1, $request->enabled_package))
                $query->whereHas(
                    'fromUser.citizen.enabledPackage',
                    function ($q) use ($key, $item) {
                        $q->where(self::ENABLED_CARD_SEARCHABLE_COLUMNS[$key], $item);
                    }
                );
        }
        if (isset($request->trans_number)) {
            $query->where('trans_number', 'like', "%$request->trans_number%");
        }
        if (isset($request->trans_status) && !in_array(-1, $request->trans_status)) {
            $query->whereIn("trans_status", $request->trans_status);
        }
        if (isset($request->trans_type)) {
            if ($request->trans_type == 0) $request->trans_type = null;
            if ($request->trans_type != -1) $query->where("trans_type", $request->trans_type);
        }

        if (isset($request->client)) {
            if ($request->client == 0) $request->client = null;
            if ($request->client != -1) {
                $query->whereHas('toUser', function ($query) use ($request) {
                    $query->where('to_user_id', $request->client);
                });
            }
        }
        //
        if (isset($request->citizen)) {
            $query->whereHas('fromUser', fn ($q) => $q->where('fullname', 'like', "%$request->citizen%"));
        }

        $new = $query->toSql();
        if ($old != $new) $this->addGlobalActivity($this, $request->query(), ActivityLog::SEARCH, 'index');
    }

    public function getCreatedAtMobileAttribute($date)
    {
        $locale = app()->getLocale();
        if (auth()->check() && auth()->user()->is_date_hijri) {
            $this->changeDateLocale($locale);
            return Hijri::convertToHijri($this->attributes['created_at'])->format('d F o h:i A');
        }
        return Carbon::parse($this->attributes['created_at'])->locale($locale)->translatedFormat('d/m/Y - h:i A');
    }

    public function scopeSortBy(Builder $query, $request)
    {
        if (!isset($request->sort["column"]) || !isset($request->sort["dir"])) return $query->latest('transactions.created_at');

        if (
            //  !in_array(Str::lower($request->sort["column"]), $this->sortableColumns) ||
            !in_array(Str::lower($request->sort["dir"]), ["asc", "desc"])
        ) {
            return $query->latest('transactions.created_at');
        } else if (in_array($request->sort["column"], self::TRANSACTION_SEARCHABLE_COLUMNS)) {

            return $query
                ->orderBy($request->sort["column"], @$request->sort["dir"]);
        } else if (in_array($request->sort["column"], self::USER_SEARCHABLE_COLUMNS)) {

            return $query->join('users', 'users.id', '=', 'transactions.from_user_id')
                ->orderBy('users.' . self::USER_SORTABLE_COLUMNS[$request->sort["column"]], @$request->sort["dir"]);
        } else if (key_exists($request->sort["column"], self::CLIENT_SORTABLE_COLUMNS)) {
            return $query->join('users', 'users.id', '=', 'transactions.to_user_id')
                ->orderBy('users.' . self::CLIENT_SORTABLE_COLUMNS[$request->sort["column"]], @$request->sort["dir"]);
        } else
            if (key_exists($request->sort["column"], self::ENABLED_CARD_sortable_COLUMNS)) {
            return
                $query
                ->leftjoin("citizen_packages", 'citizen_packages.citizen_id', '=', 'transactions.from_user_id')
                ->orderBy('citizen_packages.' . self::ENABLED_CARD_sortable_COLUMNS[$request->sort["column"]], @$request->sort["dir"])
                ->select('transactions.*', 'citizen_packages.package_id');
        }


        $query->when($request->sort, function ($q) use ($request) {
            $q->orderBy($request->sort["column"], @$request->sort["dir"]);
        });
    }

    public function getQrPathAttribute()
    {
        return @$this->attributes['qr_path'] ? 'storage/' . $this->attributes['qr_path'] : null;
    }

    public function setTransNumberAttribute($value)
    {
        $this->attributes['trans_number'] = $value;
        $this->attributes['qr_path'] = self::createQr($value);
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
            ->generate((string)$qr_value, $path);
        return 'images/transactions/' . $filname;
    }

    private static function checkOrCreateQrDirectory()
    {
        if (!\File::isDirectory(storage_path('app/public/images/transactions/'))) {
            \File::makeDirectory(storage_path('app/public' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'transactions' . DIRECTORY_SEPARATOR), 0777, true);
        }
    }


    public function fromUser()
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }

    public function toUser()
    {
        return $this->belongsTo(User::class, 'to_user_id');
    }

    public function transactionable()
    {
        return $this->morphTo();
    }

    public function transfer()
    {
        return $this->hasOne(Transfer::class, 'transactionable_id')->where('transactionable_type', Transfer::class);
    }

    public function bank(): BelongsTo
    {
        return $this->belongsTo(Bank::class, 'bank_id');
    }

    public function bankBranch(): BelongsTo
    {
        return $this->belongsTo(BankBranch::class, 'bank_branch_id');
    }

    public function citizenPackage(): BelongsTo
    {
        return $this->belongsTo(CitizenPackage::class, 'citizen_package_id', 'id');
    }
}
