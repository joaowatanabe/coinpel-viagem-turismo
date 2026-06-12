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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->integer('prefix')->unique();
            $table->string('plate', 10)->unique();
            $table->string('model');
            $table->string('chassis')->unique();
            $table->integer('capacity');
            $table->enum('vehicle_type', ['bus', 'van']);
            $table->enum('seat_type', ['reclining', 'semi_bed', 'bed']);
            $table->integer('year');
            $table->boolean('has_wifi')->default(false);
            $table->boolean('has_wc')->default(false);
            $table->boolean('has_outlet')->default(false);
            $table->boolean('has_ac')->default(false);
            $table->boolean('has_fridge')->default(false);
            $table->boolean('has_heating')->default(false);
            $table->boolean('has_video')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
