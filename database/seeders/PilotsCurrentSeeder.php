<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pilot;
use App\Models\PilotCurrent;

class PilotsCurrentSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Copying pilots data to pilotsCurrent table...');

        PilotCurrent::truncate();

        $pilots = Pilot::all();

        foreach ($pilots as $pilot) {
            PilotCurrent::create([
                'name' => $pilot->name,
                'gender' => $pilot->gender,
                'nationality' => $pilot->nationality,
                'team' => $pilot->team
            ]);
        }

        $this->command->info('Successfully copied ' . $pilots->count() . ' pilots to pilotsCurrent table');
    }
}
