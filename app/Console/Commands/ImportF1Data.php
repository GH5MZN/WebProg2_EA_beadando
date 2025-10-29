<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
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

        // Clear existing data
        $this->info('Clearing existing data...');
        Result::truncate();
        Pilot::truncate();
        GrandPrix::truncate();

        // Import pilots
        $this->importPilots();
        
        // Import Grand Prix
        $this->importGrandPrix();
        
        // Import results
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
                            'pilot_id' => (int)$data[0],
                            'name' => $data[1],
                            'gender' => $data[2],
                            'birth_date' => Carbon::createFromFormat('Y.n.j', $data[3]),
                            'nationality' => $data[4]
                        ]);
                        $count++;
                    } catch (\Exception $e) {
                        $this->warn("Error importing pilot line $i: " . $e->getMessage());
                    }
                }
            }
            $progressBar->advance();
        }

        $progressBar->finish();
        $this->info("\nImported $count pilots.");
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
                        Result::create([
                            'race_date' => Carbon::createFromFormat('Y.n.j', $data[0]),
                            'pilot_id' => (int)$data[1],
                            'position' => !empty($data[2]) ? (int)$data[2] : null,
                            'issue' => !empty($data[3]) ? $data[3] : null,
                            'team' => $data[4],
                            'car_type' => $data[5],
                            'engine' => $data[6]
                        ]);
                        $count++;
                    } catch (\Exception $e) {
                        $this->warn("Error importing result line $i: " . $e->getMessage());
                    }
                }
            }
            $progressBar->advance();
        }

        $progressBar->finish();
        $this->info("\nImported $count results.");
    }
}
