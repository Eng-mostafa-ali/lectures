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
        Schema::create('batches', function (Blueprint $table) {
    $table->id();
    // $table->foreignId('training_plan_id')->nullable()->constrained('training_plans')->onDelete('cascade');
    $table->string('batch_code')->unique()->index();
    $table->string('batch_name');
    $table->integer('trainee_count')->nullable();
    $table->date('start_date')->index();
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
        Schema::dropIfExists('batches');
    }
};
