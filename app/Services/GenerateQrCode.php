<?php

namespace App\Services;

use Illuminate\Support\Facades\File;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class GenerateQrCode
{
    private $directorySeperator = DIRECTORY_SEPARATOR;

    public function __construct(private string $qr_value, private string $path)
    {
    }

    public function createQr()
    {
        $this->checkOrCreateQrDirectory($this->path);
        $filname = time() . "_" . $this->qr_value . "_qr_code.png";
        $path = storage_path($this->path . $filname);

        QrCode::errorCorrection('H')
            ->format('png')
            ->encoding('UTF-8')
            ->merge(public_path('assets/images/logoQR.png'), .2, true)
            ->size(500)
            ->generate((string)$this->qr_value, $path);

        return 'images/citizen_wallet/' . $filname;
    }

    private function checkOrCreateQrDirectory($folder)
    {
        if (!File::isDirectory(storage_path($folder))) {
            File::makeDirectory(storage_path('app/public' . $this->directorySeperator . 'images' . $this->directorySeperator . 'citizen_wallet' . $this->directorySeperator), 0777, true);
        }
    }
}
