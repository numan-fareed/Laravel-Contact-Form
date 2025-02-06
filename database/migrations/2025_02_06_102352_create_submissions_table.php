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
        Schema::create('submissions', function (Blueprint $table) {
            $table->id();
            $table->string('name', 10);
            $table->string('email');
            $table->string('phone');
            $table->text('message');
            $table->string('street');
            $table->string('state');
            $table->string('zip');
            $table->string('country');
            $table->json('image_paths')->nullable();
            $table->json('file_paths')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('submissions');
    }
};
