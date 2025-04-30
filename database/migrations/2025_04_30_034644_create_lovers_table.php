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
        Schema::create('lovers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('pass');
            $table->text('profile_text')->nullable();
            $table->text('content')->nullable();
            $table->text('letter_text')->nullable();
            $table->string('avatar')->nullable();
            $table->string('picture1')->nullable();
            $table->string('picture2')->nullable();
            $table->string('picture3')->nullable();
            $table->string('picture4')->nullable();
            $table->string('picture5')->nullable();
            $table->string('picture6')->nullable();
            $table->string('picture7')->nullable();
            $table->string('picture8')->nullable();
            $table->string('picture9')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lovers');
    }
};
