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
       Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('schedule_id')->constrained('schedules')->cascadeOnDelete();
            $table->foreignId('trainee_id')->constrained('trainees')->cascadeOnDelete();
            $table->foreignId('trainee_section_id')->constrained('trainee_sections')->cascadeOnDelete();
            $table->foreignId('batch_id')->nullable()->constrained('batches')->onDelete('set null');
            $table->foreignId('course_id')->nullable()->constrained('courses')->onDelete('set null');
            $table->enum('status', ['present', 'absent', 'late', 'excused'])->default('absent');
            $table->timestamp('check_in')->nullable();
            $table->timestamp('check_out')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->longText('notes')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->unique(['schedule_id', 'trainee_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
