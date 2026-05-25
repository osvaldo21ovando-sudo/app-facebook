<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('reactions', function (Blueprint $table) {
            $table->id();
            $table->string('facebook_post_id');
            $table->string('facebook_user_id');
            $table->string('facebook_user_name')->nullable();
            $table->string('type')->default('LIKE');
            // LIKE | LOVE | HAHA | WOW | SAD | ANGRY | CARE
            $table->foreignId('member_id')
                  ->nullable()
                  ->constrained('members')
                  ->nullOnDelete();
            // null = persona fuera del equipo rastreado
            $table->timestamp('reacted_at')->nullable();
            $table->timestamps();

            // Una sola reacción por persona por post
            $table->unique(['facebook_post_id', 'facebook_user_id']);

            $table->foreign('facebook_post_id')
                  ->references('facebook_post_id')
                  ->on('posts')
                  ->onDelete('cascade');
            $table->index('facebook_user_id');
        });
    }

    public function down(): void { Schema::dropIfExists('reactions'); }
};
