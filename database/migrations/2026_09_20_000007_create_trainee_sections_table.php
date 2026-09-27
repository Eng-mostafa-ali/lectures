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
        Schema::create('trainee_sections', function (Blueprint $table) {
    $table->id();
    $table->string('section_code')->unique()->index();
    $table->foreignId('batch_id')->constrained('batches')->onDelete('cascade');
    $table->string('section_name');
    $table->integer('trainee_count')->default(25);
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
        Schema::dropIfExists('trainee_sections');
    }
};
