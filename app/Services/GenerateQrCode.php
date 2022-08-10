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
        $saved_file = str_replace('app/public/', '', $path) . $filname;
        $path = storage_path($path . $filname);

        QrCode::errorCorrection('H')
            ->format('png')
            ->encoding('UTF-8')
            ->merge(public_path('dashboardAssets/images/brand/logoQR.png'), .2, true)
            ->size(500)
            ->generate((string)$qr_value, $path);

        return $saved_file;
    }

    private static function checkOrCreateQrDirectory($path)
    {
        if (!File::isDirectory(storage_path($path))) {
            File::makeDirectory(storage_path($path), 0777, true);
        }
    }
}
