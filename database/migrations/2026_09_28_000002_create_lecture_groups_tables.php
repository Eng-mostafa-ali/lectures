<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // الجروب بيجمع المحاضرات اللي ليها نفس مواعيد البداية والنهاية
        Schema::create('lecture_groups', function (Blueprint $table) {
            $table->id();
            $table->dateTime('start_at');
            // وقت إرسال إيفنت تحديث الحضور بعد بداية المحاضرة بـ10 دقايق
            $table->dateTime('attendance_at');
            // وقت إلغاء المحاضرات اللي لسه ما بدأتش بعد 15 دقيقة
            $table->dateTime('auto_cancel_at');
            $table->dateTime('end_at');
            // عدد المحاضرات الموجودة في الجروب
            $table->unsignedInteger('lecture_count')->default(0);
            // أعلام بتمنع معالجة نفس الإجراء أكتر من مرة
            $table->boolean('attendance_processed')->default(false);
            $table->boolean('auto_cancel_processed')->default(false);
            $table->boolean('auto_finish_processed')->default(false);
            $table->timestamps();

            $table->unique(['start_at', 'end_at'], 'lecture_groups_times_unique');
            $table->index(['auto_cancel_processed', 'auto_cancel_at'], 'lecture_groups_cancel_processed_index');
            $table->index(['auto_finish_processed', 'end_at'], 'lecture_groups_finish_processed_index');
            $table->index(['attendance_processed', 'attendance_at'], 'lecture_groups_attendance_processed_index');
        });

        // هنا بخزن تفاصيل كل محاضرة وربطها بالجروب بتاعها
        Schema::create('lecture_group_schedules', function (Blueprint $table) {
            $table->foreignId('lecture_group_id')->constrained('lecture_groups')->cascadeOnDelete();
            $table->foreignId('schedule_id')->constrained('schedules')->cascadeOnDelete();
            // المواعيد وقت التخطيط ووقت التنفيذ 
            $table->dateTime('planned_start_at')->nullable();
            $table->dateTime('planned_end_at')->nullable();
            $table->dateTime('actual_start_at')->nullable();
            $table->dateTime('actual_end_at')->nullable();
            $table->dateTime('cancelled_at')->nullable();
            // آخر نتيجة وصلت لها المحاضرة
            $table->enum('outcome', [
                'pending',
                'in_progress',
                'auto_cancelled',
                'cancelled',
                'finished',
            ])->default('pending');
            $table->timestamps();

            $table->primary(['lecture_group_id', 'schedule_id']);
            $table->unique('schedule_id');
            $table->index('planned_start_at');
            $table->index('planned_end_at');
            $table->index('actual_start_at');
            $table->index('actual_end_at');
            $table->index('cancelled_at');
            $table->index('outcome');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lecture_group_schedules');
        Schema::dropIfExists('lecture_groups');
    }
};
