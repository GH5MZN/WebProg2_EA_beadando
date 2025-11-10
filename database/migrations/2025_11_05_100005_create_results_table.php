<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('results', function (Blueprint $table) {
            $table->id();
            $table->date('race_date');
            $table->unsignedBigInteger('pilotaaz');
            $table->integer('position')->nullable();
            $table->string('issue')->nullable();
            $table->string('team');
            $table->string('car_type');
            $table->string('engine');
            $table->timestamps();
            
            $table->foreign('pilotaaz')->references('az')->on('pilots');
            // Note: race_date connects logically to grand_prix but no foreign key constraint
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('results');
    }
};
