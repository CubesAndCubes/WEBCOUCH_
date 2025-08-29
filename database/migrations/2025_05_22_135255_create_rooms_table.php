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
            $table->timestamps();
            $table->uuid();
            $table->string('name');
            $table->float('media_seek')->nullable();
            $table->bigInteger('play_timestamp')->nullable();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('user_file_id')->nullable()->constrained('user_files');
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
