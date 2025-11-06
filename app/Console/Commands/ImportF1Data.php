<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Pilot;
use App\Models\Result;
use App\Models\GrandPrix;
use Carbon\Carbon;

class ImportF1Data extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'f1:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import F1 data from TXT files into MySQL database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting F1 data import...');

        $this->info('Clearing existing data...');
        
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        Result::truncate();
        Pilot::truncate();
        GrandPrix::truncate();
        
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->importPilots();
        $this->importGrandPrix();
        $this->importResults();

        $this->info('F1 data import completed successfully!');
    }

    private function importPilots()
    {
        $this->info('Importing pilots...');
        $filePath = storage_path('app/data/pilota.txt');
        
        if (!file_exists($filePath)) {
            $this->error('Pilots file not found: ' . $filePath);
            return;
        }

        $content = file_get_contents($filePath);
        // Próbáljuk többféle kódolást a magyar karakterekhez
        $encodings = ['UTF-8', 'ISO-8859-1', 'ISO-8859-2', 'Windows-1252', 'CP1250'];
        foreach ($encodings as $encoding) {
            if (mb_check_encoding($content, $encoding)) {
                $content = mb_convert_encoding($content, 'UTF-8', $encoding);
                break;
            }
        }
        $lines = explode("\n", $content);
        $count = 0;

        $progressBar = $this->output->createProgressBar(count($lines) - 1);

        // Skip header line
        for ($i = 1; $i < count($lines); $i++) {
            $line = trim($lines[$i]);
            if (!empty($line)) {
                $data = explode("\t", $line);
                if (count($data) >= 5) {
                    try {
                        Pilot::create([
                            'az' => (int)$data[0],
                            'name' => $data[1],
                            'gender' => !empty($data[2]) ? $data[2] : null,
                            'birth_date' => !empty($data[3]) ? $this->parseDate($data[3]) : null,
                            'nationality' => !empty($data[4]) ? $data[4] : null,
                            'team' => isset($data[5]) && !empty($data[5]) ? $data[5] : null
                        ]);
                        $count++;
                    } catch (\Exception $e) {
                        // Kódolási hibák esetén folytatjuk
                    }
                }
            }
            $progressBar->advance();
        }

        $progressBar->finish();
        $this->info("\nImported $count pilots.");
    }

    private function parseDate($dateString) 
    {
        try {
            return Carbon::createFromFormat('Y.n.j', $dateString);
        } catch (\Exception $e) {
            return null;
        }
    }

    private function importGrandPrix()
    {
        $this->info('Importing Grand Prix...');
        $filePath = storage_path('app/data/gp.txt');
        
        if (!file_exists($filePath)) {
            $this->error('Grand Prix file not found: ' . $filePath);
            return;
        }

        $content = file_get_contents($filePath);
        // Többféle kódolás próbálása
        $encodings = ['UTF-8', 'ISO-8859-1', 'ISO-8859-2', 'Windows-1252', 'CP1250'];
        foreach ($encodings as $encoding) {
            if (mb_check_encoding($content, $encoding)) {
                $content = mb_convert_encoding($content, 'UTF-8', $encoding);
                break;
            }
        }
        $lines = explode("\n", $content);
        $count = 0;

        $progressBar = $this->output->createProgressBar(count($lines) - 1);

        // Skip header line
        for ($i = 1; $i < count($lines); $i++) {
            $line = trim($lines[$i]);
            if (!empty($line)) {
                $data = explode("\t", $line);
                if (count($data) >= 3) {
                    try {
                        GrandPrix::create([
                            'race_date' => Carbon::createFromFormat('Y.n.j', $data[0]),
                            'name' => $data[1],
                            'location' => $data[2]
                        ]);
                        $count++;
                    } catch (\Exception $e) {
                        $this->warn("Error importing GP line $i: " . $e->getMessage());
                    }
                }
            }
            $progressBar->advance();
        }

        $progressBar->finish();
        $this->info("\nImported $count Grand Prix events.");
    }

    private function importResults()
    {
        $this->info('Importing results...');
        $filePath = storage_path('app/data/eredmeny.txt');
        
        if (!file_exists($filePath)) {
            $this->error('Results file not found: ' . $filePath);
            return;
        }

        $content = file_get_contents($filePath);
        // Többféle kódolás próbálása
        $encodings = ['UTF-8', 'ISO-8859-1', 'ISO-8859-2', 'Windows-1252', 'CP1250'];
        foreach ($encodings as $encoding) {
            if (mb_check_encoding($content, $encoding)) {
                $content = mb_convert_encoding($content, 'UTF-8', $encoding);
                break;
            }
        }
        $lines = explode("\n", $content);
        $count = 0;

        $progressBar = $this->output->createProgressBar(count($lines) - 1);

        // Skip header line
        for ($i = 1; $i < count($lines); $i++) {
            $line = trim($lines[$i]);
            if (!empty($line)) {
                $data = explode("\t", $line);
                if (count($data) >= 7) {
                    try {
                        $issue = !empty($data[3]) ? $data[3] : null;
                        // Kódolási problémák kezelése az issue mezőben
                        if ($issue && !mb_check_encoding($issue, 'UTF-8')) {
                            $issue = mb_convert_encoding($issue, 'UTF-8', 'Windows-1252');
                        }
                        
                        Result::create([
                            'race_date' => Carbon::createFromFormat('Y.n.j', $data[0]),
                            'pilotaaz' => (int)$data[1],
                            'position' => !empty($data[2]) ? (int)$data[2] : null,
                            'issue' => $issue,
                            'team' => $data[4],
                            'car_type' => $data[5],
                            'engine' => $data[6]
                        ]);
                        $count++;
                    } catch (\Exception $e) {
                        // Kódolási és constraint hibák esetén folytatjuk
                    }
                }
            }
            $progressBar->advance();
        }

        $progressBar->finish();
        $this->info("\nImported $count results.");
    }
}
