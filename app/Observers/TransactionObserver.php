<?php

namespace App\Observers;

use App\Models\Transaction;

class TransactionObserver
{
    /**
     * Handle events after all transactions are committed.
     *
     * @var bool
     */
    public $afterCommit = true;

    /**
     * Handle the User "created" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function created(Transaction $transaction)
    {
        $transaction = Transaction::findOrFail($transaction->id);
        $qr_code = self::createQr($transaction->trans_number);
        $transaction->update(['qr_path' => $qr_code]);
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
}
