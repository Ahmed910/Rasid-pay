<?php

namespace App\Models;

use App\Models\CardPackage\CardPackage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Loggable;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Builder;

class Transaction extends Model
{

    use HasFactory, Uuid, Loggable;
    protected $guarded = ['number', 'created_at', 'updated_at'];

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

        if (isset($request->number)) {
            $query->where('number', $request->number);
        }

        if (isset($request->user_identity)) {
            $query->where("user_identity", $request->user_identity);
        }

        if (isset($request->status)) {
            $query->where("status", $request->status);
        }

        if (isset($request->type)) {
            $query->where("type", $request->type);
        }

        if (isset($request->transaction_from)) {
            $query->where("amount", '<=', $request->transaction_from);
        }
        if (isset($request->transaction_to)) {
            $query->where("amount", '>=', $request->transaction_to);
        }

        if (isset($request->card_package_id)) {
            $query->whereHas('card', function ($query) use ($request) {
                $query->where('id', $request->card_package_id);
            });
        }
    }

    public function card()
    {
        return $this->belongsTo(CardPackage::class, 'card_package_id');
    }

    public function citizen()
    {
        return $this->belongsTo(User::class, 'citizen_id');
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }
}
