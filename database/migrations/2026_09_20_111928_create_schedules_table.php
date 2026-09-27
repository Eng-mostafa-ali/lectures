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
       Schema::create('schedules', function (Blueprint $table) {
    $table->id();
    $table->foreignId('batch_id')->constrained('batches')->cascadeOnUpdate()->cascadeOnDelete();
    $table->foreignId('trainee_section_id')->constrained('trainee_sections')->cascadeOnUpdate()->cascadeOnDelete();
    $table->foreignId('trainer_id')->constrained('users')->cascadeOnUpdate()->cascadeOnDelete();
    $table->foreignId('room_id')->nullable()->constrained('rooms')->cascadeOnUpdate()->nullOnDelete();
    // true = Online, false = Onsite
    $table->enum('delivery_mode', ['onsite', 'online', 'hybrid'])->default('onsite');
    $table->string('online_link')->nullable();
    $table->uuid('recurrence_key')->nullable()->index();
    $table->foreignId('course_id')->constrained('courses')->cascadeOnUpdate()->cascadeOnDelete();
    $table->date('date')->index();
    $table->time('start_time')->setPrecision(0);
    $table->time('end_time')->setPrecision(0);
    $table->enum('status', ['not_started', 'in_progress', 'finished', 'cancelled'])->default('not_started');
    $table->string('created_by')->nullable();
    $table->string('updated_by')->nullable();
    $table->longText('notes')->nullable();
    $table->softDeletes();
    $table->timestamps();
    $table->unique(['room_id', 'date', 'start_time'], 'unique_room_schedule');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
