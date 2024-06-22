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
        Schema::create('reservation_periodiques', function (Blueprint $table) {
            $table->id();
            $table->date('start_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->string('type_period'); // daily, weekly, monthly
            $table->date('end_date');
            $table->enum('etat', ['accepted','pending', 'rejected'])->default('pending');
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('infrastructure_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservation_periodiques');
    }
};
