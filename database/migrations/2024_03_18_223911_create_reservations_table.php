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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->date('res_date');
            $table->time('res_heure');

            $table->enum('etat',['accepte','refuse','enattente']);

            $table->foreignId('infrastructure_id')
                ->constrained('infrastructures')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('client_id')
                ->constrained('clients')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
