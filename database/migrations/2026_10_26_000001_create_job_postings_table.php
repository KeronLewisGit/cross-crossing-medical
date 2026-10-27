<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_postings', function (Blueprint $table) {
            $table->id();
            $table->string('slug', 140)->unique();
            $table->string('title', 120);
            // A key from ccmc.career_roles, so applications sort into the same groups.
            $table->string('role_key', 40);
            $table->string('department', 80)->nullable();
            $table->string('employment', 20)->default('full-time');
            $table->string('status', 10)->default('draft')->index();
            $table->text('summary')->nullable();
            $table->text('duties')->nullable();
            $table->text('requirements')->nullable();
            $table->date('closes_on')->nullable();
            // Sample postings from DemoSeeder; shown with a "Sample posting" badge.
            $table->boolean('is_demo')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_postings');
    }
};
