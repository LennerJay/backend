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
        Schema::create('evaluatees_users', function (Blueprint $table) {
            $table->foreignId('evaluatee_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('user_id')->constrained('users','id_number')->onDelete('cascade')->onUpdate('cascade');
            $table->boolean('is_done')->default(false);
            $table->integer('questionaire_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluatees_users');
    }
};
