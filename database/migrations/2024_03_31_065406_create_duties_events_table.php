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
        Schema::create('duties_events', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('duty_id')
                ->references('id')
                ->on('duties')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->enum('type', ['Off', 'Standby', 'Flight', 'CheckIn', 'CheckOut', 'Unknown'])->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('duties_events');
    }
};
