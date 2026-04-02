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
        Schema::create('actes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('huissier_id')->nullable()->constrained()->nullOnDelete();
            $table->string('reference')->unique();
            $table->string('type'); // notification, execution, constat
            $table->string('status')->default('pending'); // pending, in_progress, completed, archived
            $table->text('objet');
            $table->date('date_depot');
            $table->date('date_execution')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('actes');
    }
};
