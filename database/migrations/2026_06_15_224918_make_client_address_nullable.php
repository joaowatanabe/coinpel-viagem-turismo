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
        Schema::table('clients', function (Blueprint $table) {
            $table->string('zip_code', 9)->nullable()->change();
            $table->string('street')->nullable()->change();
            $table->string('number', 10)->nullable()->change();
            $table->string('city')->nullable()->change();
            $table->string('state', 2)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->string('zip_code', 9)->nullable(false)->change();
            $table->string('street')->nullable(false)->change();
            $table->string('number', 10)->nullable(false)->change();
            $table->string('city')->nullable(false)->change();
            $table->string('state', 2)->nullable(false)->change();
        });
    }
};
