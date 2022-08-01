<?php

namespace App\Services;

use Illuminate\Support\Facades\File;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class GenerateQrCode
{
    private $directorySeperator = DIRECTORY_SEPARATOR;

    public static function createQr(string $qr_value, string $path)
    {
        $this->checkOrCreateQrDirectory($path);
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

    private function checkOrCreateQrDirectory($folder)
    {
        if (!File::isDirectory(storage_path($folder))) {
            File::makeDirectory(storage_path('app/public' . $this->directorySeperator . str_replace('app/public', '', $folder) . $this->directorySeperator), 0777, true);
        }
    }
}
