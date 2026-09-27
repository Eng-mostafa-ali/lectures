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
        Schema::create('rooms', function (Blueprint $table) {
    $table->id();
    $table->string('room_code')->unique()->index();
    // $table->foreignId('type_place_id')->nullable()->constrained('type_places')->onDelete('set null');
    // $table->foreignId('floor_id')->nullable()->constrained('floors')->onDelete('set null');
    $table->string('description_ar')->nullable()->index();
    $table->string('description_en')->nullable()->index();
    $table->enum('status', ['active', 'inactive'])->default('active');
    $table->boolean('used_in_schedule')->default(false)->index();
    $table->string('creat   ed_by')->nullable();
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
        Schema::dropIfExists('rooms');
    }
};
