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
        Schema::create('folders', function (Blueprint $table) {
            $table->id();
            $table->string('folder_name');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('full_address')->nullable();
            $table->date('birth_date');
            $table->string('region')->nullable();
            $table->string('phone_number', 15);
            $table->unsignedInteger('family_number')->nullable();
            $table->unsignedInteger('total_siblings')->nullable();
            $table->unsignedInteger('sibling_position')->nullable();
            $table->date('start_date')->nullable();
            $table->string('education_level')->nullable();
            $table->timestamps();
        });

        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('folder_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('message')->nullable();
            $table->timestamp('date')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
        Schema::dropIfExists('folders');
    }
};
