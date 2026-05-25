<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable()->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();  // nullable porque login es via FB

            // Campos Facebook
            $table->string('facebook_id')->nullable()->unique();
            $table->string('facebook_name')->nullable();
            $table->string('facebook_avatar')->nullable();
            $table->text('facebook_token')->nullable();           // user access token
            $table->text('facebook_token_long')->nullable();      // long-lived token
            $table->timestamp('token_expires_at')->nullable();

            // Rol y vínculo
            $table->string('role')->default('member');            // admin | member | viewer
            $table->foreignId('member_id')
                  ->nullable()
                  ->constrained('members')
                  ->nullOnDelete();
            $table->enum('match_status', ['unmatched', 'pending_approval', 'approved', 'rejected'])
                  ->default('unmatched');
            // unmatched        = se logueó pero no hay member correspondiente
            // pending_approval = sistema encontró posible match, espera confirmación admin
            // approved         = admin confirmó el match
            // rejected         = admin rechazó el match

            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void { Schema::dropIfExists('users'); }
};
