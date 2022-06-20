<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Support\Str;

class GeneratePdf
{
    private $mpdf;

    /**
     * generate new \Mpdf\Mpdf with our configurations
     *
     */
    public function newFile()
    {
        $this->mpdf = new \Mpdf\Mpdf([
            'fontDir' => [
                public_path() . '/dashboardAssets/fonts',
            ],
            'fontdata' =>  [
                'cairo' => [
                    'R' => 'Cairo-Regular.ttf',
                    'I' => 'Cairo-Regular.ttf',
                    'useOTL' => 0xFF,
                    'useKashida' => 75,
                ]
            ],
            'default_font' => 'cairo'
        ]);

        $this->mpdf->autoScriptToLang = true;
        $this->mpdf->autoLangToFont = true;
        $this->mpdf->simpleTables = true;
        $this->mpdf->packTableData = true;
        $this->mpdf->SetDirectionality(LaravelLocalization::getCurrentLocaleDirection());

        return $this;
    }

    /**
     * Add your view
     * @param  Illuminate\Support\Facades\View $view
     * @param array $data
     */
    public function view(string $view, array $data)
    {
        $this->mpdf->WriteHTML(view($view, $data));

        return $this;
    }

    /**
     * Export PDF File
     */
    public function export()
    {
        return $this->mpdf->Output();
    }

    /**
     * Store On Local
     * @param string $filePath
     */
    public function storeOnLocal($folder): string
    {
        $basePath = base_path('storage/app/');
        $path = $basePath . $folder . uniqid() . ".pdf";
        $this->mpdf->Output($path, 'F');
        $path = Str::replaceFirst($basePath, '', $path);

        return $path;
    }
}
