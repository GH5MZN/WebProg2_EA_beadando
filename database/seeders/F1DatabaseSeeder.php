<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pilot;
use App\Models\Result;
use App\Models\GrandPrix;
use Carbon\Carbon;

class F1DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Starting F1 database seeding...');

        // Seed Pilots
        $this->seedPilots();
        $this->command->info('Pilots seeded successfully!');

        // Seed Grand Prix
        $this->seedGrandPrix();
        $this->command->info('Grand Prix seeded successfully!');

        // Seed Results
        $this->seedResults();
        $this->command->info('Results seeded successfully!');

        $this->command->info('F1 database seeding completed!');
    }

    private function seedPilots()
    {
        $filePath = storage_path('app/data/pilota.txt');
        
        if (!file_exists($filePath)) {
            $this->command->error('Pilots file not found: ' . $filePath);
            return;
        }

        $content = file_get_contents($filePath);
        $lines = explode("\n", $content);

        // Skip header line
        for ($i = 1; $i < count($lines); $i++) {
            $line = trim($lines[$i]);
            if (!empty($line)) {
                $data = explode("\t", $line);
                if (count($data) >= 5) {
                    try {
                        \App\Models\Pilot::create([
                            'pilot_id' => (int)$data[0],
                            'name' => $data[1],
                            'gender' => $data[2],
                            'birth_date' => Carbon::createFromFormat('Y.n.j', $data[3]),
                            'nationality' => $data[4]
                        ]);
                    } catch (\Exception $e) {
                        $this->command->warn("Error seeding pilot line $i: " . $e->getMessage());
                    }
                }
            }
        }
    }

    private function seedGrandPrix()
    {
        $filePath = storage_path('app/data/gp.txt');
        
        if (!file_exists($filePath)) {
            $this->command->error('Grand Prix file not found: ' . $filePath);
            return;
        }

        $content = file_get_contents($filePath);
        $lines = explode("\n", $content);

        // Skip header line
        for ($i = 1; $i < count($lines); $i++) {
            $line = trim($lines[$i]);
            if (!empty($line)) {
                $data = explode("\t", $line);
                if (count($data) >= 3) {
                    try {
                        \App\Models\GrandPrix::create([
                            'race_date' => Carbon::createFromFormat('Y.n.j', $data[0]),
                            'name' => $data[1],
                            'location' => $data[2]
                        ]);
                    } catch (\Exception $e) {
                        $this->command->warn("Error seeding GP line $i: " . $e->getMessage());
                    }
                }
            }
        }
    }

    private function seedResults()
    {
        $filePath = storage_path('app/data/eredmeny.txt');
        
        if (!file_exists($filePath)) {
            $this->command->error('Results file not found: ' . $filePath);
            return;
        }

        $content = file_get_contents($filePath);
        $lines = explode("\n", $content);

        // Skip header line
        for ($i = 1; $i < count($lines); $i++) {
            $line = trim($lines[$i]);
            if (!empty($line)) {
                $data = explode("\t", $line);
                if (count($data) >= 7) {
                    try {
                        \App\Models\Result::create([
                            'race_date' => Carbon::createFromFormat('Y.n.j', $data[0]),
                            'pilot_id' => (int)$data[1],
                            'position' => !empty($data[2]) ? (int)$data[2] : null,
                            'issue' => !empty($data[3]) ? $data[3] : null,
                            'team' => $data[4],
                            'car_type' => $data[5],
                            'engine' => $data[6]
                        ]);
                    } catch (\Exception $e) {
                        $this->command->warn("Error seeding result line $i: " . $e->getMessage());
                    }
                }
            }
        }
    }
}
