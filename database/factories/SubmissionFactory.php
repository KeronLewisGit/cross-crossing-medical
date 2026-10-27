<?php

namespace Database\Factories;

use App\Enums\SubmissionStatus;
use App\Enums\SubmissionType;
use App\Models\Submission;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Submission> */
class SubmissionFactory extends Factory
{
    protected $model = Submission::class;

    /** @return array<string, mixed> */
    public function definition(): array
    {
        return [
            'type' => SubmissionType::Appointment,
            'status' => SubmissionStatus::New,
            'name' => fake()->name(),
            'phone' => '868-652-'.fake()->numerify('####'),
            'email' => fake()->safeEmail(),
            'contact_pref' => 'phone',
            'service_key' => 'cardiology',
            'details' => ['for_whom' => 'self', 'days' => ['mon'], 'window' => 'morning', 'seen_before' => 'yes'],
            'consented_at' => now(),
        ];
    }

    public function type(SubmissionType $type): static
    {
        return $this->state(fn () => match ($type) {
            SubmissionType::Registration => ['type' => $type, 'service_key' => null, 'details' => ['patient_name' => 'Test Patient', 'patient_dob' => '1980-01-01', 'for_whom' => 'self', 'id_type' => 'national_id', 'insured' => false]],
            SubmissionType::Dialysis => ['type' => $type, 'service_key' => 'dialysis', 'details' => ['situation' => 'new', 'schedule' => 'mwf', 'shift' => array_key_first((array) ccmc('dialysis.shifts'))]],
            SubmissionType::Career => ['type' => $type, 'service_key' => 'registered-nurse', 'details' => ['experience' => '3-5', 'availability' => ['full-time']]],
            SubmissionType::Enquiry => ['type' => $type, 'service_key' => null, 'message' => 'A question', 'details' => ['topic' => 'general']],
            default => ['type' => $type],
        });
    }
}
