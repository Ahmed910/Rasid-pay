<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Support\Str;

class GeneratePdf
{
    private $mpdf;

    /**
     * generate new \Mpdf\Mpdf with our configurations
     *
     */
    public function newFile($orientation = 'P')
    {
        set_time_limit(-1);
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
            'debug' => true,
            'allow_output_buffering' => true,
            'mode' => 'utf-8',
            'format' => 'A4',
            'margin_top' => 60,     // 30mm not pixel
            'margin_footer' => 10,     // 10mm
            'orientation' => $orientation
        ]);

        $this->mpdf->autoScriptToLang = true;
        $this->mpdf->autoLangToFont = true;
        $this->mpdf->simpleTables = true;
        $this->mpdf->packTableData = true;

        if (!Route::is('summary_file')) {
            $this->mpdf->SetWatermarkImage(public_path('dashboardAssets/images/brand/fintech.png'), -3, 'F');
            $this->mpdf->showWatermarkImage = true;
            $this->mpdf->SetDirectionality(LaravelLocalization::getCurrentLocaleDirection());
        }

        return $this;
    }

    /**
     * set header for pdf file
     */
    public function setHeader(string $topic, $createdFrom)
    {
        $date_from   = format_date(request('created_from')) ?? format_date($createdFrom);
        $date_to     = format_date(request('created_to')) ?? format_date(now());
        $userId      = auth()->user()->login_id ?? '';

        $this->mpdf->SetHTMLHeader(view('dashboard.exports.header', compact(
            'date_from',
            'date_to',
            'userId',
            'topic',
        )));

        return $this;
    }

    /**
     * Add your view
     * @param  Illuminate\Support\Facades\View $view
     * @param array $data
     */
    public function view(string $view, $rows, int $key, int $chunk)
    {
        $this->mpdf->WriteHTML(view($view, compact('rows', 'key', 'chunk')));

        return $this;
    }


    public function mobileView($view, $data)
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
        $basePath = base_path('storage/app/public/');
        $this->checkIfFolderExists($basePath . $folder);
        $path = $basePath . $folder . uniqid() . time() . ".pdf";
        $this->mpdf->Output($path, \Mpdf\Output\Destination::FILE);
        $path = Str::replaceFirst($basePath, '', $path);

        return $path;
    }

    private function checkIfFolderExists($folder)
    {
        if (!File::isDirectory($folder)) {
            File::makeDirectory($folder, 0777, true);
        }
    }

    public static function mergePdfFiles(array $filenames, $outFile, $orientation = 'P')
    {
        $mpdf = new \Mpdf\Mpdf([
            'fontDir' => [
                public_path() . '/dashboardAssets/fonts',
            ],
            'fontdata' => [
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
            'nbpgPrefix' => ' ',
            'nbpgSuffix' => ' ',
            'mode' => 'utf-8',
            'orientation' => $orientation
        ]);
        $outFile = base_path('storage/app/public/') . $outFile;
        $mpdf->SetFooter('{PAGENO}{nbpg}');
        if ($filenames) {
            $filesTotal = sizeof($filenames);
            $fileNumber = 1;
            if (!file_exists($outFile)) {
                $handle = fopen($outFile, 'w');
                fclose($handle);
            }

            foreach ($filenames as $fileName) {
                if (file_exists($fileName)) {
                    $pagesInFile = $mpdf->setSourceFile($fileName);
                    for ($i = 1; $i <= $pagesInFile; $i++) {
                        $tplId = $mpdf->ImportPage($i); // in mPdf v8 should be 'importPage($i)'
                        $mpdf->UseTemplate($tplId);
                        if (($fileNumber < $filesTotal) || ($i != $pagesInFile)) {
                            $mpdf->WriteHTML('<pagebreak />');
                        }
                    }
                }
                $fileNumber++;
            }
            $mpdf->Output($outFile, \Mpdf\Output\Destination::FILE);
            File::delete($filenames);

            return url(str_replace(base_path('storage/app/public/'), 'storage/', $outFile));
        }
    }

    public static function createNewFile(
        string $topic,
        string|null $createdFrom,
        string $view,
        $rows,
        int $key,
        int $chunk,
        string $storagePath,
        $orientation = 'P'
    ): string {
        return base_path('storage/app/public/') . (new static)->newFile($orientation)
            ->setHeader($topic, $createdFrom)
            ->view($view, $rows, $key, $chunk)
            ->storeOnLocal($storagePath);
    }
}
