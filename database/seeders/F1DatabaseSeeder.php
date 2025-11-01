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
            echo "File not found: {$filePath}\n";
            return;
        }

        $content = file_get_contents($filePath);
        $content = mb_convert_encoding($content, 'UTF-8', 'Windows-1252');
        $lines = explode("\n", $content);
        $lines = array_filter($lines, function($line) { return trim($line) !== ''; });
        
        // Skip header
        array_shift($lines);
        
        foreach ($lines as $lineNumber => $line) {
            try {
                $data = explode("\t", trim($line));
                
                if (count($data) >= 5) {
                    Pilot::create([
                        'pilot_id' => (int)trim($data[0]),
                        'name' => trim($data[1]),
                        'gender' => trim($data[2]) === 'F' ? 'Male' : 'Female',
                        'birth_date' => Carbon::createFromFormat('Y.n.j', trim($data[3])),
                        'nationality' => trim($data[4])
                    ]);
                }
            } catch (\Exception $e) {
                echo "Error seeding pilot line " . ($lineNumber + 2) . ": " . $e->getMessage() . " Data: " . $line . "\n";
            }
        }
        
        echo "Pilots seeded successfully!\n";
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

        // Skip header line (datum	nev	helyszin)
        for ($i = 1; $i < count($lines); $i++) {
            $line = trim($lines[$i]);
            if (!empty($line)) {
                $data = explode("\t", $line);
                if (count($data) >= 3) {
                    try {
                        \App\Models\GrandPrix::create([
                            'race_date' => Carbon::createFromFormat('Y.n.j', $data[0]), // datum
                            'name' => $data[1] . ' Grand Prix', // nev
                            'location' => $data[2] // helyszin
                        ]);
                    } catch (\Exception $e) {
                        $this->command->warn("Error seeding GP line $i: " . $e->getMessage() . " Data: " . implode('|', $data));
                    }
                }
            }
        }
    }

    private function seedResults()
    {
        $filePath = storage_path('app/data/eredmeny.txt');
        
        if (!file_exists($filePath)) {
            echo "File not found: {$filePath}\n";
            return;
        }

        $content = file_get_contents($filePath);
        $content = mb_convert_encoding($content, 'UTF-8', 'Windows-1252');
        $lines = explode("\n", $content);
        $lines = array_filter($lines, function($line) { return trim($line) !== ''; });
        
        // Skip header
        array_shift($lines);
        
        foreach ($lines as $lineNumber => $line) {
            try {
                $data = explode("\t", trim($line));
                
                if (count($data) >= 7) {
                    // Only create if pilot exists
                    $pilotId = (int)trim($data[1]);
                    if (Pilot::where('pilot_id', $pilotId)->exists()) {
                        Result::create([
                            'race_date' => Carbon::createFromFormat('Y.n.j', trim($data[0])),
                            'pilot_id' => $pilotId,
                            'position' => trim($data[2]) === '' ? null : (int)trim($data[2]),
                            'issue' => trim($data[3]) === '' ? null : trim($data[3]),
                            'team' => trim($data[4]),
                            'car_type' => trim($data[5]),
                            'engine' => trim($data[6])
                        ]);
                    }
                }
            } catch (\Exception $e) {
                echo "Error seeding result line " . ($lineNumber + 2) . ": " . $e->getMessage() . " Data: " . $line . "\n";
            }
        }
        
        echo "Results seeded successfully!\n";
    }
}
