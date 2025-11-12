<?php<?php<?php



namespace Database\Seeders;



use Illuminate\Database\Console\Seeds\WithoutModelEvents;namespace Database\Seeders;namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Pilot;

use App\Models\PilotCurrent;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PilotsCurrentSeeder extends Seeder

{use Illuminate\Database\Seeder;use Illuminate\Database\Seeder;

    public function run(): void

    {use App\Models\Pilot;use App\Models\Pilot;

        $this->command->info('Copying pilots data to pilotsCurrent table...');

use App\Models\PilotCurrent;use App\Models\PilotCurrent;

        PilotCurrent::truncate();



        $pilots = Pilot::all();

class PilotsCurrentSeeder extends Seederclass PilotsCurrentSeeder extends Seeder

        foreach ($pilots as $pilot) {

            PilotCurrent::create([{{

                'name' => $pilot->name,

                'gender' => $pilot->gender,    public function run(): void    public function run(): void

                'nationality' => $pilot->nationality,

                'team' => $pilot->team    {    {

            ]);

        }        $this->command->info('Copying pilots data to pilotsCurrent table...');        $this->command->info('Copying pilots data to pilotsCurrent table...');



        $this->command->info('Successfully copied ' . $pilots->count() . ' pilots to pilotsCurrent table');

    }

}        PilotCurrent::truncate();        PilotCurrent::truncate();



        $pilots = Pilot::all();        $pilots = Pilot::all();



        foreach ($pilots as $pilot) {        foreach ($pilots as $pilot) {

            PilotCurrent::create([            PilotCurrent::create([

                'name' => $pilot->name,                'name' => $pilot->name,

                'gender' => $pilot->gender,                'gender' => $pilot->gender,

                'nationality' => $pilot->nationality,                'nationality' => $pilot->nationality,

                'team' => $pilot->team                'team' => $pilot->team

            ]);            ]);

        }        }



        $this->command->info('Successfully copied ' . $pilots->count() . ' pilots to pilotsCurrent table');        $this->command->info('Successfully copied ' . $pilots->count() . ' pilots to pilotsCurrent table');

    }    }

}}
