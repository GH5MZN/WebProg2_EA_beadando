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
            $table->unsignedBigInteger('pilot_id');
            $table->integer('position')->nullable();
            $table->string('issue')->nullable();
            $table->string('team');
            $table->string('car_type');
            $table->string('engine');
            $table->timestamps();
            
            $table->foreign('pilot_id')->references('pilot_id')->on('pilots');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('results');
    }
};
