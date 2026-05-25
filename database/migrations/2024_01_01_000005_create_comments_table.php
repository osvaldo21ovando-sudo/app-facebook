<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->string('facebook_comment_id')->unique();
            $table->string('facebook_post_id');
            $table->string('facebook_user_id');
            $table->string('facebook_user_name')->nullable();
            $table->text('message')->nullable();
            $table->foreignId('member_id')
                  ->nullable()
                  ->constrained('members')
                  ->nullOnDelete();
            // null = la persona que comentó NO es parte del equipo rastreado
            $table->timestamp('commented_at')->nullable();
            $table->timestamps();

            $table->foreign('facebook_post_id')
                  ->references('facebook_post_id')
                  ->on('posts')
                  ->onDelete('cascade');
            $table->index('facebook_user_id');
            $table->index('facebook_post_id');
        });
    }

    public function down(): void { Schema::dropIfExists('comments'); }
};
