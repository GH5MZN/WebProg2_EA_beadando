<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PilotCurrent;
use Illuminate\Support\Facades\DB;

class PilotCurrentSeeder extends Seeder
{
    public function run(): void
    {
        // Ideiglenesen kikapcsoljuk a foreign key ellenőrzéseket
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Töröljük az előző adatokat
        PilotCurrent::truncate();
        
        // Visszakapcsoljuk a foreign key ellenőrzéseket
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Jelenlegi 2025-ös F1 pilóták hozzáadása (frissítve 2025 szezonra)
        $currentPilots = [
            ['pilot_id' => 1001, 'name' => 'Max Verstappen', 'nationality' => 'holland', 'team' => 'Red Bull Racing'],
            ['pilot_id' => 1002, 'name' => 'Yuki Tsunoda', 'nationality' => 'japán', 'team' => 'Red Bull Racing'],
            ['pilot_id' => 1003, 'name' => 'Lewis Hamilton', 'nationality' => 'brit', 'team' => 'Ferrari'],
            ['pilot_id' => 1004, 'name' => 'Charles Leclerc', 'nationality' => 'monacói', 'team' => 'Ferrari'],
            ['pilot_id' => 1005, 'name' => 'George Russell', 'nationality' => 'brit', 'team' => 'Mercedes'],
            ['pilot_id' => 1006, 'name' => 'Kimi Antonelli', 'nationality' => 'olasz', 'team' => 'Mercedes'],
            ['pilot_id' => 1007, 'name' => 'Lando Norris', 'nationality' => 'brit', 'team' => 'McLaren'],
            ['pilot_id' => 1008, 'name' => 'Oscar Piastri', 'nationality' => 'ausztrál', 'team' => 'McLaren'],
            ['pilot_id' => 1009, 'name' => 'Fernando Alonso', 'nationality' => 'spanyol', 'team' => 'Aston Martin'],
            ['pilot_id' => 1010, 'name' => 'Lance Stroll', 'nationality' => 'kanadai', 'team' => 'Aston Martin'],
            ['pilot_id' => 1011, 'name' => 'Pierre Gasly', 'nationality' => 'francia', 'team' => 'Alpine'],
            ['pilot_id' => 1012, 'name' => 'Jack Doohan', 'nationality' => 'ausztrál', 'team' => 'Alpine'],
            ['pilot_id' => 1013, 'name' => 'Carlos Sainz Jr.', 'nationality' => 'spanyol', 'team' => 'Williams'],
            ['pilot_id' => 1014, 'name' => 'Alex Albon', 'nationality' => 'thai', 'team' => 'Williams'],
            ['pilot_id' => 1015, 'name' => 'Nico Hülkenberg', 'nationality' => 'német', 'team' => 'Kick Sauber'],
            ['pilot_id' => 1016, 'name' => 'Gabriel Bortoleto', 'nationality' => 'brazil', 'team' => 'Kick Sauber'],
            ['pilot_id' => 1017, 'name' => 'Oliver Bearman', 'nationality' => 'brit', 'team' => 'Haas'],
            ['pilot_id' => 1018, 'name' => 'Esteban Ocon', 'nationality' => 'francia', 'team' => 'Haas'],
            ['pilot_id' => 1019, 'name' => 'Isack Hadjar', 'nationality' => 'francia', 'team' => 'Racing Bulls'],
            ['pilot_id' => 1020, 'name' => 'Liam Lawson', 'nationality' => 'új-zélandi', 'team' => 'Racing Bulls'],
        ];

        foreach ($currentPilots as $pilot) {
            PilotCurrent::create($pilot);
        }

        $this->command->info('Jelenlegi pilóták sikeresen betöltve a pilotsCurrent táblába!');
    }
}