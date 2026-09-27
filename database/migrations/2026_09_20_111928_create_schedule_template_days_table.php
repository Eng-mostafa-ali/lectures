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
       Schema::create('schedule_template_days', function (Blueprint $table) {
    $table->id();
    $table->foreignId('schedule_template_id')->constrained()->onDelete('cascade');
    $table->string('day'); // Sunday, Monday...
    $table->softDeletes();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedule_template_days');
    }
};
