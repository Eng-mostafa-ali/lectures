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
       Schema::create('trainees', function (Blueprint $table) {
    $table->id();
    $table->string('academic_number')->unique()->index();
    $table->foreignId('trainee_section_id')->nullable()->constrained('trainee_sections')->onDelete('cascade');
    // $table->foreignId('entity_id')->nullable()->constrained('entities')->nullOnDelete();

    $table->string('first_name_ar')->nullable()->index();
    $table->string('father_name_ar')->nullable()->index();
    $table->string('grand_father_name_ar')->nullable()->index();
    $table->string('family_name_ar')->nullable()->index();

    $table->string('first_name_en')->nullable()->index();
    $table->string('father_name_en')->nullable()->index();
    $table->string('grand_father_name_en')->nullable()->index();
    $table->string('family_name_en')->nullable()->index();

    $table->string('username')->nullable()->unique();
    $table->string('email')->unique()->nullable()->index();
    $table->timestamp('email_verified_at')->nullable();
    $table->string('password')->nullable();
    $table->string('phone')->unique()->nullable()->index();
    $table->timestamp('phone_verified_at')->nullable();

    $table->bigInteger('ident_num')->nullable();
    $table->string('image')->nullable();
    $table->enum('gender', ['male','female'])->nullable();


    $table->enum('receive_emails', ['active', 'inactive'])->default('active');
    $table->enum('receive_SMS', ['active', 'inactive'])->default('active');
    $table->enum('receive_notify', ['active', 'inactive'])->default('active');
    $table->enum('language_type', ['arabic', 'english'])->default('english');

    $table->enum('status', [
        'no_show',          // Case 1: No Show – Withdrawal before HRDF support
        'withdrawal',       // Case 2: Withdrawal after HRDF support
        'dismissed',        // Case 3: Dismissal due to absences/failure
        'active',           // Case 4: Active Trainee
        'inactive',           // Case 4: Inactive Trainee
        'graduated'         // Case 5: Graduated Trainee
    ])->default('active');

    $table->string('created_by')->nullable();
    $table->string('updated_by')->nullable();
    $table->rememberToken();
    $table->softDeletes();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trainees');
    }
};
