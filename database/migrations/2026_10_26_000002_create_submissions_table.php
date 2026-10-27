<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('submissions', function (Blueprint $table) {
            $table->id();
            $table->string('reference', 20)->unique();
            // appointment | registration | dialysis | career | enquiry (App\Enums\SubmissionType)
            $table->string('type', 16)->index();
            $table->string('status', 16)->default('new')->index();
            // The person we call back: the patient, a parent or relative, or the applicant.
            $table->string('name', 120);
            $table->string('phone', 30);
            $table->string('phone_digits', 20)->nullable()->index();
            $table->string('email')->nullable();
            $table->string('contact_pref', 10)->default('phone');
            // Clinic, test or department key from config/ccmc.php, or a careers role key.
            $table->string('service_key', 40)->nullable();
            $table->foreignId('job_posting_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            // What staff booked after calling back (appointment, assessment, first visit or interview).
            $table->date('booked_date')->nullable()->index();
            $table->string('booked_time', 5)->nullable();
            // Type-specific answers: preferred days and time window, patient details, insurer, role ...
            $table->json('details')->nullable();
            $table->text('message')->nullable();
            // When the person ticked the Data Protection Act consent.
            $table->timestamp('consented_at')->nullable();
            $table->string('source_url', 300)->nullable();
            $table->timestamp('first_contacted_at')->nullable();
            $table->timestamp('status_changed_at')->nullable();
            // Sample rows from DemoSeeder; never real patients.
            $table->boolean('is_demo')->default(false);
            $table->timestamps();
            $table->index(['status', 'created_at']);
        });

        Schema::create('submission_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('submission_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            // note | status | assign | system | access
            $table->string('kind', 12)->default('note');
            $table->text('body');
            $table->timestamps();
        });

        Schema::create('submission_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('submission_id')->constrained()->cascadeOnDelete();
            // id_card | insurance_card | referral | cv | certificate
            $table->string('kind', 16);
            // Always the private "local" disk; streamed to authorised staff only.
            $table->string('path');
            $table->string('original_name', 200);
            $table->string('mime', 100)->nullable();
            $table->unsignedInteger('size')->default(0);
            $table->timestamps();
        });

        // Every time a member of staff opens an uploaded document (Data Protection Act audit trail).
        Schema::create('file_accesses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('submission_file_id')->constrained()->cascadeOnDelete();
            $table->foreignId('submission_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('ip', 45)->nullable();
            $table->timestamp('created_at')->nullable()->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('file_accesses');
        Schema::dropIfExists('submission_files');
        Schema::dropIfExists('submission_notes');
        Schema::dropIfExists('submissions');
    }
};
