<?php
// posts migration
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('facebook_post_id')->unique();
            $table->text('message')->nullable();
            $table->string('story')->nullable();
            $table->string('type')->nullable();           // photo, video, status, link
            $table->string('permalink')->nullable();
            $table->string('full_picture')->nullable();   // URL imagen
            $table->integer('comment_count')->default(0);
            $table->integer('reaction_count')->default(0);
            $table->integer('share_count')->default(0);
            $table->integer('member_reaction_count')->default(0);   // reacciones de miembros
            $table->integer('member_comment_count')->default(0);    // comentarios de miembros
            $table->timestamp('published_at')->nullable();
            $table->timestamp('last_synced_at')->nullable();
            $table->timestamps();

            $table->index('published_at');
        });
    }
    public function down(): void { Schema::dropIfExists('posts'); }
};
