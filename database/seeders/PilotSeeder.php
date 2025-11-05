<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pilot;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Exception;

class PilotSeeder extends Seeder
{
    public function run(): void
    {
        // Ideiglenesen kikapcsoljuk a foreign key ellenőrzéseket
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Töröljük az előző adatokat
        Pilot::truncate();
        
        // Visszakapcsoljuk a foreign key ellenőrzéseket
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Olvassuk be a txt fájlt
        $filePath = storage_path('app/data/pilota.txt');
        
        if (!file_exists($filePath)) {
            $this->command->error('A pilota.txt fájl nem található!');
            return;
        }

        // Olvassuk be a txt fájlt
        $filePath = storage_path('app/data/pilota.txt');
        
        if (!file_exists($filePath)) {
            $this->command->error('A pilota.txt fájl nem található!');
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
            
            if (count($data) >= 5) {
                // Az oszlopok: az, nev, nem, szuldat, nemzet
                $pilotId = trim($data[0]);
                $name = trim($data[1]);
                $gender = trim($data[2]);
                $birthDate = trim($data[3]);
                $nationality = trim($data[4]);

                // Dátum feldolgozása
                $parsedDate = null;
                if (!empty($birthDate) && $birthDate !== '') {
                    try {
                        // A formátum: 1911.6.24
                        $dateArray = explode('.', $birthDate);
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

                Pilot::create([
                    'pilot_id' => $pilotId,
                    'name' => $name,
                    'gender' => $gender === 'F' ? 'F' : ($gender === 'N' ? 'N' : 'F'),
                    'birth_date' => $parsedDate,
                    'nationality' => !empty($nationality) ? $nationality : null,
                ]);
            }
        }

        $this->command->info('Pilóták sikeresen betöltve a txt fájlból!');
    }
}