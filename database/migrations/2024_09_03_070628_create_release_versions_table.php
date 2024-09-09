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
        Schema::create('release_versions', function (Blueprint $table) {
            $table->id();
            $table->string('number')->nullable();
            $table->string('file_path')->nullable();
            $table->string('platform')->nullable();
            $table->dateTime('published_at')->nullable();
            $table->boolean('force_update')->nullable();
            $table->boolean('is_release')->default(false);
            $table->tinyInteger('status')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('release_versions');
    }
};
