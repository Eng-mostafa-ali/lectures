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
        Schema::create('courses', function (Blueprint $table) {
    $table->id();
    // $table->foreignId('program_id')->nullable()->constrained('programs')->onDelete('set null');
    $table->string('course_code')->unique()->index();
    $table->string('name');
    $table->enum('status', ['active', 'inactive'])->default('active');
    $table->string('created_by')->nullable();
    $table->string('updated_by')->nullable();
    $table->longText('notes')->nullable();
    $table->softDeletes();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
