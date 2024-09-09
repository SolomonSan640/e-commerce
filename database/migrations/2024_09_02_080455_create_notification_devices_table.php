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
        Schema::create('notification_devices', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('device_id')->nullable()->constrained('device_tokens');
            $table->bigInteger('notification_id')->nullable()->constrained('notifications');
            $table->boolean('is_read')->default(0);
            $table->integer('status')->default(1);
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notification_devices');
    }
};
