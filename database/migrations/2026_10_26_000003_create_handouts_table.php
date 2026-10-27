<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('handouts', function (Blueprint $table) {
            $table->id();
            $table->string('slug', 140)->unique();
            $table->string('title', 140);
            // A key from Handout::CATEGORIES.
            $table->string('category', 30)->index();
            $table->text('summary')->nullable();
            // Who wrote it (CCMC, CDC, NIH ...).
            $table->string('publisher', 120)->nullable();
            // Either a link to the publisher's own copy, or a PDF uploaded to the public uploads disk.
            $table->string('url', 300)->nullable();
            $table->string('file_path')->nullable();
            $table->unsignedInteger('file_size')->nullable();
            $table->boolean('published')->default(true)->index();
            $table->unsignedSmallInteger('sort')->default(100);
            $table->timestamps();
        });

        Schema::create('settings', function (Blueprint $table) {
            // "name", not "key": KEY is a reserved word in MySQL.
            $table->string('name', 60)->primary();
            $table->text('value')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
        Schema::dropIfExists('handouts');
    }
};
