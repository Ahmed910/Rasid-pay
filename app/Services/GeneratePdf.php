<?php

namespace App\Services;

use App\Jobs\GeneratePdfFile;
use App\Models\Bank\Bank;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
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
            'default_font' => 'cairo',
            'pagenumPrefix' => __('dashboard.general.page_number'),
            'pagenumSuffix' => ' | ',
            'nbpgPrefix' => '',
            'nbpgSuffix' => ''
        ]);

        $this->mpdf->autoScriptToLang = true;
        $this->mpdf->autoLangToFont = true;
        $this->mpdf->simpleTables = true;
        $this->mpdf->packTableData = true;

        if (!Route::is('summary_file')) {
            $this->mpdf->SetWatermarkImage(asset('dashboardAssets/images/brand/fintech.png'), -3, 'F');
            $this->mpdf->showWatermarkImage = true;
            $this->mpdf->SetDirectionality(LaravelLocalization::getCurrentLocaleDirection());
            $this->mpdf->SetFooter('{PAGENO}{nbpg}');
        }

        return $this;
    }

    /**
     * Add your view
     * @param  Illuminate\Support\Facades\View $view
     * @param array $data
     */
    public function view(string $view, array $data_array)
    {
        if (!request()->has('created_from')) {
            $createdFrom = Bank::selectRaw('MIN(created_at) as min_created_at')->value('min_created_at');
        }

        $this->mpdf->WriteHTML(view(
            'dashboard.exports.top_header',
            [
                'date_from'   => format_date(request('created_from')) ?? format_date($createdFrom),
                'date_to'     => format_date(request('created_to')) ?? format_date(now()),
                'userId'      => auth()->user()->login_id,
            ]
        ));

        foreach ($data_array['banks']->chunk(5) as $data) {
            GeneratePdfFile::dispatch($view, $data);
        }

        $this->mpdf->WriteHTML(view('dashboard.exports.bottom'));

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
        $basePath = base_path('storage/app/public/');
        $this->checkIfFolderExists($basePath . $folder);
        $path = $basePath . $folder . uniqid() . time() . ".pdf";
        $this->mpdf->Output($path, 'F');
        $path = Str::replaceFirst($basePath, '', $path);

        return $path;
    }

    private function checkIfFolderExists($folder)
    {
        if (!File::isDirectory($folder)) {
            File::makeDirectory($folder, 0777, true);
        }
    }
}
