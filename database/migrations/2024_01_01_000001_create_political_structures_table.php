<?php

// ============================================================
// MIGRACIONES — Ejecutar en este orden
// Archivo de referencia. Crear cada uno en database/migrations/
// ============================================================

// ─────────────────────────────────────────────────────────────
// 1. create_political_structures_table.php
// ─────────────────────────────────────────────────────────────
// Schema::create('political_structures', function (Blueprint $table) {
//     $table->id();
//     $table->string('name');           // "Sección 5", "Zona Norte", "Partido X"
//     $table->string('type');           // partido | sección | zona | brigada | etc.
//     $table->foreignId('parent_id')->nullable()->constrained('political_structures');
//     $table->timestamps();
// });

// ─────────────────────────────────────────────────────────────
// 2. create_users_table.php (tabla estándar Laravel + campos FB)
// ─────────────────────────────────────────────────────────────
// Schema::create('users', function (Blueprint $table) {
//     $table->id();
//     $table->string('name');
//     $table->string('email')->nullable()->unique();
//     $table->string('facebook_id')->nullable()->unique();
//     $table->string('facebook_name')->nullable();
//     $table->string('facebook_avatar')->nullable();
//     $table->text('facebook_token')->nullable();         // user access token
//     $table->timestamp('token_expires_at')->nullable();
//     $table->string('role')->default('member');          // admin | member
//     $table->foreignId('member_id')->nullable()->constrained('members');
//     $table->timestamps();
// });

// ─────────────────────────────────────────────────────────────
// 3. create_members_table.php
// ─────────────────────────────────────────────────────────────
// Schema::create('members', function (Blueprint $table) {
//     $table->id();
//     $table->string('name');
//     $table->string('facebook_id')->nullable()->unique();   // se llena al hacer match
//     $table->string('facebook_name')->nullable();
//     $table->string('facebook_avatar')->nullable();
//     $table->string('phone')->nullable();
//     $table->string('position')->nullable();               // cargo político
//     $table->foreignId('political_structure_id')->nullable()->constrained();
//     $table->enum('status', ['pending', 'linked', 'inactive'])->default('pending');
//     // pending  = capturado manualmente, sin login FB aún
//     // linked   = ya hizo login y se hizo match
//     // inactive = dado de baja
//     $table->foreignId('linked_user_id')->nullable()->constrained('users');
//     $table->timestamps();
// });

// ─────────────────────────────────────────────────────────────
// 4. create_posts_table.php
// ─────────────────────────────────────────────────────────────
// Schema::create('posts', function (Blueprint $table) {
//     $table->id();
//     $table->string('facebook_post_id')->unique();
//     $table->text('message')->nullable();
//     $table->string('story')->nullable();
//     $table->string('type')->nullable();                   // photo, video, status, link
//     $table->string('permalink')->nullable();
//     $table->integer('comment_count')->default(0);
//     $table->integer('reaction_count')->default(0);
//     $table->integer('share_count')->default(0);
//     $table->timestamp('published_at')->nullable();
//     $table->timestamp('last_synced_at')->nullable();
//     $table->timestamps();
// });

// ─────────────────────────────────────────────────────────────
// 5. create_comments_table.php
// ─────────────────────────────────────────────────────────────
// Schema::create('comments', function (Blueprint $table) {
//     $table->id();
//     $table->string('facebook_comment_id')->unique();
//     $table->string('facebook_post_id');
//     $table->string('facebook_user_id');
//     $table->string('facebook_user_name')->nullable();
//     $table->text('message')->nullable();
//     $table->foreignId('member_id')->nullable()->constrained(); // null si no es del equipo
//     $table->timestamp('commented_at')->nullable();
//     $table->timestamps();

//     $table->foreign('facebook_post_id')->references('facebook_post_id')->on('posts');
//     $table->index('facebook_user_id');
// });

// ─────────────────────────────────────────────────────────────
// 6. create_reactions_table.php
// ─────────────────────────────────────────────────────────────
// Schema::create('reactions', function (Blueprint $table) {
//     $table->id();
//     $table->string('facebook_post_id');
//     $table->string('facebook_user_id');
//     $table->string('facebook_user_name')->nullable();
//     $table->string('type')->default('LIKE');   // LIKE, LOVE, HAHA, WOW, SAD, ANGRY, CARE
//     $table->foreignId('member_id')->nullable()->constrained();
//     $table->timestamp('reacted_at')->nullable();
//     $table->timestamps();

//     $table->unique(['facebook_post_id', 'facebook_user_id']); // 1 reacción por persona por post
//     $table->foreign('facebook_post_id')->references('facebook_post_id')->on('posts');
//     $table->index('facebook_user_id');
// });

// ─────────────────────────────────────────────────────────────
// 7. create_sync_logs_table.php
// ─────────────────────────────────────────────────────────────
// Schema::create('sync_logs', function (Blueprint $table) {
//     $table->id();
//     $table->string('type');          // posts | comments | reactions | matching
//     $table->string('status');        // success | error
//     $table->integer('records_synced')->default(0);
//     $table->text('message')->nullable();
//     $table->json('meta')->nullable();
//     $table->timestamp('started_at');
//     $table->timestamp('finished_at')->nullable();
//     $table->timestamps();
// });

// ─────────────────────────────────────────────────────────────
// ARCHIVOS REALES A CREAR:
// php artisan make:migration create_political_structures_table
// php artisan make:migration create_members_table
// php artisan make:migration add_facebook_fields_to_users_table
// php artisan make:migration create_posts_table
// php artisan make:migration create_comments_table
// php artisan make:migration create_reactions_table
// php artisan make:migration create_sync_logs_table
// ─────────────────────────────────────────────────────────────


// ============================================================
// MIGRATION REAL — political_structures
// ============================================================
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('political_structures', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type')->default('general'); // partido | seccion | zona | brigada
            $table->foreignId('parent_id')->nullable()->constrained('political_structures')->nullOnDelete();
            $table->string('color')->nullable(); // para el dashboard
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('political_structures'); }
};
