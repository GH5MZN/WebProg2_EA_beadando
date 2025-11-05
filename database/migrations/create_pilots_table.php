<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pilots', function (Blueprint $table) {
            $table->id('pilot_id');
            $table->string('name');
            $table->enum('gender', ['M', 'F', 'N'])->nullable();
            $table->date('birth_date')->nullable();
            $table->string('nationality')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pilots');
    }
};
