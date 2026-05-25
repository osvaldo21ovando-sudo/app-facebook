<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('sync_logs', function (Blueprint $table) {
            $table->id();
            $table->string('type');       // posts | comments | reactions | matching
            $table->string('status');     // running | success | error
            $table->integer('records_synced')->default(0);
            $table->text('message')->nullable();
            $table->json('meta')->nullable();
            $table->timestamp('started_at');
            $table->timestamp('finished_at')->nullable();
            $table->timestamps();

            $table->index(['type', 'status']);
        });
    }

    public function down(): void { Schema::dropIfExists('sync_logs'); }
};
