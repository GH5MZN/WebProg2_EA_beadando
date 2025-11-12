<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Result;
use Illuminate\Support\Facades\DB;
use Exception;

class ResultSeeder extends Seeder
{
    public function run(): void
    {
        // Ideiglenesen kikapcsoljuk a foreign key ellenőrzéseket
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Töröljük az előző adatokat
        Result::truncate();
        
        // Visszakapcsoljuk a foreign key ellenőrzéseket
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Olvassuk be a txt fájlt UTF-8 kódolással
        $filePath = storage_path('app/data/eredmeny.txt');
        
        if (!file_exists($filePath)) {
            $this->command->error('Az eredmeny.txt fájl nem található!');
            return;
        }

        $content = file_get_contents($filePath);
        
        // Windows-1252 vagy CP1252 konverzió UTF-8-ra 
        if (!mb_check_encoding($content, 'UTF-8')) {
            // Próbáljuk Windows-1252 vagy ISO-8859-2 kódolásból
            $content = mb_convert_encoding($content, 'UTF-8', 'Windows-1252');
            if (strpos($content, '�') !== false) {
                // Ha még mindig rossz, próbáljuk ISO-8859-2-vel
                $content = file_get_contents($filePath);
                $content = mb_convert_encoding($content, 'UTF-8', 'ISO-8859-2');
            }
        }
        $lines = explode("\n", $content);
        
        // Első sor a header, ezt átugorjuk
        $header = array_shift($lines);
        
        $results = [];
        $lineNumber = 2; // Második sortól kezdjük (első header)
        
        foreach ($lines as $line) {
            $line = trim($line);
            if (empty($line)) continue;
            
            try {
                // Tab karakterrel elválasztott értékek
                $fields = explode("\t", $line);
                
                if (count($fields) < 7) {
                    $this->command->warn("Hiányos sor a {$lineNumber}. sorban: {$line}");
                    $lineNumber++;
                    continue;
                }
                
                // Dátum konvertálása
                $dateString = trim($fields[0]);
                $date = \DateTime::createFromFormat('Y.m.d', $dateString);
                if (!$date) {
                    $this->command->warn("Hibás dátum formátum a {$lineNumber}. sorban: {$dateString}");
                    $lineNumber++;
                    continue;
                }
                
                $pilotId = (int)trim($fields[1]);
                $position = !empty(trim($fields[2])) ? (int)trim($fields[2]) : null;
                $error = !empty(trim($fields[3])) ? trim($fields[3]) : null;
                $team = trim($fields[4]);
                $car_type = trim($fields[5]);
                $engine = trim($fields[6]);
                
                // Egyenként beszúrjuk az adatokat
                Result::create([
                    'race_date' => $date->format('Y-m-d'),
                    'pilotaaz' => $pilotId,
                    'position' => $position,
                    'issue' => $error,
                    'team' => $team,
                    'car_type' => $car_type,
                    'engine' => $engine,
                ]);
                
            } catch (Exception $e) {
                $this->command->warn("Hiba a {$lineNumber}. sor feldolgozásakor: " . $e->getMessage());
            }
            
            $lineNumber++;
        }
        
        $count = Result::count();
        $this->command->info("Eredmények sikeresen betöltve az eredmeny.txt fájlból! Összesen {$count} rekord.");
    }
}