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
        Schema::create('pilots', function (Blueprint $table) {
            $table->id();
            $table->integer('pilot_id')->unique(); // az mező
            $table->string('name'); // nev mező
            $table->char('gender', 1); // nem mező (F/M)
            $table->date('birth_date'); // szuldat mező
            $table->string('nationality'); // nemzet mező
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pilots');
    }
};
