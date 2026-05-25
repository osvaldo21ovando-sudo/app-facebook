<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('facebook_id')->nullable()->unique();
            $table->string('facebook_name')->nullable();
            $table->string('facebook_avatar')->nullable();
            $table->string('phone')->nullable();
            $table->string('position')->nullable();               // cargo político
            $table->foreignId('political_structure_id')
                  ->nullable()
                  ->constrained('political_structures')
                  ->nullOnDelete();
            $table->enum('status', ['pending', 'linked', 'inactive'])->default('pending');
            // pending  = capturado manualmente, sin login FB aún
            // linked   = ya hizo login y se confirmó el match
            // inactive = dado de baja
            $table->timestamps();
        });
    }

    public function down(): void { Schema::dropIfExists('members'); }
};
