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
    public function run(): void
    {
        $this->command->info('Starting F1 database seeding...');

        $this->seedPilots();
        $this->command->info('Pilots seeded successfully!');

        $this->seedGrandPrix();
        $this->command->info('Grand Prix seeded successfully!');

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
        
        array_shift($lines);
        
        foreach ($lines as $lineNumber => $line) {
            try {
                $data = explode("\t", trim($line));
                
                if (count($data) >= 5) {
                    $genderCode = trim($data[2]);
                    $gender = $genderCode;
                    
                    $birthDate = null;
                    if (!empty(trim($data[3]))) {
                        try {
                            $birthDate = Carbon::createFromFormat('Y.n.j', trim($data[3]));
                        } catch (\Exception $e) {
                            $birthDate = null;
                        }
                    }
                    
                    Pilot::create([
                        'name' => trim($data[1]),
                        'gender' => !empty($gender) ? $gender : null,
                        'birth_date' => $birthDate,
                        'nationality' => !empty(trim($data[4])) ? trim($data[4]) : null
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
        
        if (!mb_check_encoding($content, 'UTF-8')) {
            $content = mb_convert_encoding($content, 'UTF-8', 'Windows-1252');
            
            if (!mb_check_encoding($content, 'UTF-8')) {
                $content = mb_convert_encoding($content, 'UTF-8', 'ISO-8859-2');
            }
        }

        $lines = explode("\n", $content);

        $characterMap = [
            'Ã¡' => 'á', 'Ã©' => 'é', 'Ã­' => 'í', 'Ã³' => 'ó', 'Ãµ' => 'ő', 'Ã¶' => 'ö', 'Ãº' => 'ú', 'Å±' => 'ű', 'Ã¼' => 'ü',
            'Ã' => 'Á', 'Ã‰' => 'É', 'ÃŽ' => 'Í', 'Ã"' => 'Ó', 'Å' => 'Ő', 'Ã–' => 'Ö', 'Ãš' => 'Ú', 'Å°' => 'Ű', 'Ãœ' => 'Ü',
            'Ã¤' => 'ä', 'Ã§' => 'ç', 'Ã±' => 'ñ', 'Ã ' => 'à', 'Ã¢' => 'â', 'Ãª' => 'ê', 'Ã®' => 'î', 'Ã´' => 'ô', 'Ã»' => 'û',
            'NÃ©metorszÃ¡g' => 'Németország',
            'Ã–sztrÃ¡k' => 'Osztrák',
            'FranciaorszÃ¡g' => 'Franciaország',
            'SpanyolorszÃ¡g' => 'Spanyolország',
            'OlaszorszÃ¡g' => 'Olaszország',
            'MagyarorszÃ¡g' => 'Magyarország',
            'PortugÃ¡lia' => 'Portugália',
            'BrazÃ­lia' => 'Brazília',
            'ArgentÃ­na' => 'Argentína',
            'JapÃ¡n' => 'Japán',
            'KÃ­na' => 'Kína',
            'TÃ¶rÃ¶korszÃ¡g' => 'Törökország',
            'SvÃ©dorszÃ¡g' => 'Svédország',
            'DÃ©l-Afrika' => 'Dél-Afrika',
            'MexikÃ³' => 'Mexikó',
            'MarokkÃ³' => 'Marokkó',
            'EurÃ³pa' => 'Európa',
            'SvÃ¡jc' => 'Svájc',
            'AusztrÃ¡lia' => 'Ausztrália',
            'MalÃ¡jzia' => 'Malájzia'
        ];

        // Skip header line (datum	nev	helyszin)
        for ($i = 1; $i < count($lines); $i++) {
            $line = trim($lines[$i]);
            if (!empty($line)) {
                // Karakterek javítása
                foreach ($characterMap as $wrong => $correct) {
                    $line = str_replace($wrong, $correct, $line);
                }
                
                $data = explode("\t", $line);
                if (count($data) >= 3) {
                    try {
                        // További tisztítás
                        $name = trim($data[1]);
                        $location = trim($data[2]);
                        
                        // Egyedi javítások
                        $name = str_replace(['Ã¡', 'Ã©', 'Ã­', 'Ã³', 'Ã¶', 'Ã¼'], ['á', 'é', 'í', 'ó', 'ö', 'ü'], $name);
                        $location = str_replace(['Ã¡', 'Ã©', 'Ã­', 'Ã³', 'Ã¶', 'Ã¼'], ['á', 'é', 'í', 'ó', 'ö', 'ü'], $location);
                        
                        \App\Models\GrandPrix::create([
                            'race_date' => Carbon::createFromFormat('Y.n.j', trim($data[0])),
                            'name' => $name . ' Grand Prix',
                            'location' => $location
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
