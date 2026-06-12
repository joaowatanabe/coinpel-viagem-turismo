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
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('birth_date');
            $table->string('registration')->unique();
            $table->string('cpf', 14)->unique();
            $table->string('rg', 20);
            $table->string('zip_code', 9);
            $table->string('street');
            $table->string('number', 10);
            $table->string('city');
            $table->string('state', 2); // e.g. RS, SP
            $table->string('email')->unique();
            $table->string('phone', 20);
            $table->string('profile_photo_path')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drivers');
    }
};
