<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('results', function (Blueprint $table) {
            $table->id();
            $table->date('race_date'); // datum mező
            $table->integer('pilot_id'); // pilotaaz mező
            $table->integer('position')->nullable(); // helyezes mező
            $table->string('issue')->nullable(); // hiba mező
            $table->string('team'); // csapat mező
            $table->string('car_type'); // tipus mező
            $table->string('engine'); // motor mező
            $table->timestamps();
            
            $table->foreign('pilot_id')->references('pilot_id')->on('pilots');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('results');
    }
};
