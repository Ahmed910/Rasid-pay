<?php

namespace App\Services;

use Illuminate\Support\Facades\File;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class GenerateQrCode
{
    public static function createQr(string $qr_value, string $path)
    {
        self::checkOrCreateQrDirectory($path);
        $filname = time() . "_" . $qr_value . "_qr_code.png";
        $path = storage_path($path . $filname);

        QrCode::errorCorrection('H')
            ->format('png')
            ->encoding('UTF-8')
            ->merge(public_path('assets/images/logoQR.png'), .2, true)
            ->size(500)
            ->generate((string)$qr_value, $path);

        return str_replace('app/public', '', $path) . $filname;
    }

    private static function checkOrCreateQrDirectory($folder)
    {
        if (!File::isDirectory(storage_path($folder))) {
            File::makeDirectory(storage_path($folder)), 0777, true);
        }
    }
}
