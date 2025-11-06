<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pilot;
use Illuminate\Support\Facades\DB;

class F1_2025_PilotsSeeder extends Seeder
{
    public function run(): void
    {
        // Először töröljük a kapcsolódó adatokat
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('results')->truncate();
        DB::table('pilots')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $pilots = [
            ['pilot_id' => 1, 'name' => 'Lando Norris', 'nationality' => 'British', 'team' => 'McLaren', 'gender' => 'M', 'birth_date' => '1999-11-13'],
            ['pilot_id' => 2, 'name' => 'Oscar Piastri', 'nationality' => 'Australian', 'team' => 'McLaren', 'gender' => 'M', 'birth_date' => '2001-04-06'],
            ['pilot_id' => 3, 'name' => 'Max Verstappen', 'nationality' => 'Dutch', 'team' => 'Red Bull Racing', 'gender' => 'M', 'birth_date' => '1997-09-30'],
            ['pilot_id' => 4, 'name' => 'George Russell', 'nationality' => 'British', 'team' => 'Mercedes', 'gender' => 'M', 'birth_date' => '1998-02-15'],
            ['pilot_id' => 5, 'name' => 'Charles Leclerc', 'nationality' => 'Monégasque', 'team' => 'Ferrari', 'gender' => 'M', 'birth_date' => '1997-10-16'],
            ['pilot_id' => 6, 'name' => 'Lewis Hamilton', 'nationality' => 'British', 'team' => 'Ferrari', 'gender' => 'M', 'birth_date' => '1985-01-07'],
            ['pilot_id' => 7, 'name' => 'Andrea Kimi Antonelli', 'nationality' => 'Italian', 'team' => 'Mercedes', 'gender' => 'M', 'birth_date' => '2006-08-25'],
            ['pilot_id' => 8, 'name' => 'Alexander Albon', 'nationality' => 'Thai', 'team' => 'Williams', 'gender' => 'M', 'birth_date' => '1996-03-23'],
            ['pilot_id' => 9, 'name' => 'Nico Hulkenberg', 'nationality' => 'German', 'team' => 'Kick Sauber', 'gender' => 'M', 'birth_date' => '1987-08-19'],
            ['pilot_id' => 10, 'name' => 'Isack Hadjar', 'nationality' => 'French', 'team' => 'Racing Bulls', 'gender' => 'M', 'birth_date' => '2004-09-28'],
            ['pilot_id' => 11, 'name' => 'Carlos Sainz Jr.', 'nationality' => 'Spanish', 'team' => 'Williams', 'gender' => 'M', 'birth_date' => '1994-09-01'],
            ['pilot_id' => 12, 'name' => 'Fernando Alonso', 'nationality' => 'Spanish', 'team' => 'Aston Martin', 'gender' => 'M', 'birth_date' => '1981-07-29'],
            ['pilot_id' => 13, 'name' => 'Oliver Bearman', 'nationality' => 'British', 'team' => 'Haas F1 Team', 'gender' => 'M', 'birth_date' => '2005-05-08'],
            ['pilot_id' => 14, 'name' => 'Lance Stroll', 'nationality' => 'Canadian', 'team' => 'Aston Martin', 'gender' => 'M', 'birth_date' => '1998-10-29'],
            ['pilot_id' => 15, 'name' => 'Liam Lawson', 'nationality' => 'New Zealand', 'team' => 'Racing Bulls', 'gender' => 'M', 'birth_date' => '2002-02-11'],
            ['pilot_id' => 16, 'name' => 'Esteban Ocon', 'nationality' => 'French', 'team' => 'Haas F1 Team', 'gender' => 'M', 'birth_date' => '1996-09-17'],
            ['pilot_id' => 17, 'name' => 'Yuki Tsunoda', 'nationality' => 'Japanese', 'team' => 'Red Bull Racing', 'gender' => 'M', 'birth_date' => '2000-05-11'],
            ['pilot_id' => 18, 'name' => 'Pierre Gasly', 'nationality' => 'French', 'team' => 'Alpine', 'gender' => 'M', 'birth_date' => '1996-02-07'],
            ['pilot_id' => 19, 'name' => 'Gabriel Bortoleto', 'nationality' => 'Brazilian', 'team' => 'Kick Sauber', 'gender' => 'M', 'birth_date' => '2004-10-14'],
            ['pilot_id' => 20, 'name' => 'Franco Colapinto', 'nationality' => 'Argentine', 'team' => 'Alpine', 'gender' => 'M', 'birth_date' => '2003-05-27'],
        ];
    

        foreach ($pilots as $pilot) {
            Pilot::create($pilot);
        }

        $this->command->info('2025-ös F1 pilóták sikeresen hozzáadva (Jack Doohan nélkül)!');
    }
}