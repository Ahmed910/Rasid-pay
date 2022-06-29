<?php

namespace App\Console\Commands;

use App\Models\Locale\Locale;
use App\Models\Locale\LocaleTranslation;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ConvertFileToMigration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'file:insert {file : The name of file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Insert (PHP array) Transalations File To Database Locales';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $fileName = $this->argument('file');

        foreach (['ar', 'en'] as $locale) {
            $file = resource_path("lang/$locale/$fileName.php");
            $content  = include $file;

            if (!is_file($file)) return $this->error('File Not Found');
            if (!is_array($content)) return $this->error('File Does Not Content Array');

            foreach (Arr::dot($content) as $key => $value) {
                $id = (string) Str::uuid();
                $allLocales[] = ['id' => $id, 'key' => $key, 'file' => $fileName];
                $transLocales[] = ['id' => (string) Str::uuid(), 'locale_id' => $id, 'locale' => $locale, 'value' => $value];
            }
        }

        try {
            DB::beginTransaction();
            Locale::where('file', $fileName)->get()->map->deleteTranslations();
            Locale::where('file', $fileName)->delete();
            Locale::insert($allLocales);
            LocaleTranslation::insert($transLocales);
            DB::commit();

            return $this->info('Done Seeds');
        } catch (\Exception $e) {
            DB::rollBack();

            return $this->error($e->getMessage());
        }
    }
}
