<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GrandPrix;
use Illuminate\Support\Facades\DB;
use Exception;

class GrandPrixSeeder extends Seeder
{
    public function run(): void
    {
        // Ideiglenesen kikapcsoljuk a foreign key ellenőrzéseket
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Töröljük az előző adatokat
        GrandPrix::truncate();
        
        // Visszakapcsoljuk a foreign key ellenőrzéseket
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Olvassuk be a txt fájlt
        $filePath = storage_path('app/data/gp.txt');
        
        if (!file_exists($filePath)) {
            $this->command->error('A gp.txt fájl nem található!');
            return;
        }

        $content = file_get_contents($filePath);
        // Konvertáljuk UTF-8-ra ha szükséges
        if (!mb_check_encoding($content, 'UTF-8')) {
            $content = mb_convert_encoding($content, 'UTF-8', 'Windows-1252');
        }
        
        $lines = explode("\n", $content);
        // Távolítsuk el a \r karaktereket és az üres sorokat
        $lines = array_filter(array_map('trim', $lines), function($line) {
            return !empty($line);
        });
        
        // Átugorjuk a header sort
        array_shift($lines);

        foreach ($lines as $line) {
            $data = explode("\t", $line);
            
            if (count($data) >= 3) {
                // Az oszlopok: datum, nev, helyszin
                $raceDate = trim($data[0]);
                $name = trim($data[1]);
                $location = trim($data[2]);

                // Dátum feldolgozása
                $parsedDate = null;
                if (!empty($raceDate) && $raceDate !== '') {
                    try {
                        // A formátum: 1994.05.15
                        $dateArray = explode('.', $raceDate);
                        if (count($dateArray) === 3) {
                            $year = $dateArray[0];
                            $month = str_pad($dateArray[1], 2, '0', STR_PAD_LEFT);
                            $day = str_pad($dateArray[2], 2, '0', STR_PAD_LEFT);
                            $parsedDate = "$year-$month-$day";
                        }
                    } catch (Exception $e) {
                        $parsedDate = null;
                    }
                }

                if ($parsedDate) {
                    GrandPrix::create([
                        'race_date' => $parsedDate,
                        'name' => $name,
                        'location' => $location,
                    ]);
                }
            }
        }

        $this->command->info('Grand Prix versenyek sikeresen betöltve a txt fájlból!');
    }
}