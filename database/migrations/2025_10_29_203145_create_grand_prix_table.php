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
        Schema::create('grand_prix', function (Blueprint $table) {
            $table->id();
            $table->date('race_date'); // datum mező
            $table->string('name'); // nev mező
            $table->string('location'); // helyszin mező
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grand_prix');
    }
};
