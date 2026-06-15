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
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->foreignId('trip_id')->nullable()->constrained('trips')->nullOnDelete();
            $table->decimal('price', 10, 2);
            $table->boolean('includes_hotel')->default(false);
            $table->boolean('includes_meals')->default(false);
            $table->boolean('includes_guide')->default(false);
            $table->integer('max_people');
            $table->enum('status', ['available', 'sold_out', 'inactive'])->default('available');
            $table->foreignId('created_by')->constrained('users')->restrictOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
