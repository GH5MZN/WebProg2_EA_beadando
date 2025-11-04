<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pilotsCurrent', function (Blueprint $table) {
            $table->id('pilot_id');
            $table->string('name');
            $table->enum('gender', ['M', 'F', 'N'])->nullable();
            $table->string('nationality')->nullable();
            $table->string('team', 100)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pilotsCurrent');
    }
};
