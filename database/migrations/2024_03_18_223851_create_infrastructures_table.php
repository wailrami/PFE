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
        Schema::create('infrastructures', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('ville');
            $table->string('cite');
            $table->text('description')->nullable();
            $table->foreignId('gestionnaire_id')->nullable()->constrained()->onDelete('set null')->onUpdate('cascade');
            //onDeleteCascade?
            $table->morphs('infrastructable');
            

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('infrastructures');
    }
};
