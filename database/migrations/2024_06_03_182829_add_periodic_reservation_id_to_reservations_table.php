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
        Schema::table('reservations', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('periodic_reservation_id')->nullable()->after('id');
            $table->foreign('periodic_reservation_id')->references('id')->on('reservation_periodiques')->onDelete('cascade');
        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            //
            $table->dropForeign(['periodic_reservation_id']);
            $table->dropColumn('periodic_reservation_id');
        });
    }
};
