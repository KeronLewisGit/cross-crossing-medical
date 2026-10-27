<?php

namespace App\Enums;

/** What came in through the website. Each has its own reference prefix, e.g. AP-26-00042. */
enum SubmissionType: string
{
    case Appointment = 'appointment';
    case Registration = 'registration';
    case Dialysis = 'dialysis';
    case Career = 'career';
    case Enquiry = 'enquiry';

    public function label(): string
    {
        return match ($this) {
            self::Appointment => 'Appointment request',
            self::Registration => 'New-patient registration',
            self::Dialysis => 'Dialysis enquiry',
            self::Career => 'Job application',
            self::Enquiry => 'General enquiry',
        };
    }

    public function plural(): string
    {
        return match ($this) {
            self::Appointment => 'Appointment requests',
            self::Registration => 'Registrations',
            self::Dialysis => 'Dialysis enquiries',
            self::Career => 'Job applications',
            self::Enquiry => 'Enquiries',
        };
    }

    public function prefix(): string
    {
        return match ($this) {
            self::Appointment => 'AP',
            self::Registration => 'PR',
            self::Dialysis => 'DI',
            self::Career => 'CV',
            self::Enquiry => 'EN',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::Appointment => 'calendar',
            self::Registration => 'id-card',
            self::Dialysis => 'droplet',
            self::Career => 'briefcase',
            self::Enquiry => 'message',
        };
    }

    /**
     * A new submission nobody has acted on within this many hours is overdue.
     * Patients asking for a call back come first; registrations are checked before the
     * first visit; applications get a working-week window.
     */
    public function responseHours(): int
    {
        return match ($this) {
            self::Appointment, self::Dialysis => 2,
            self::Enquiry => 4,
            self::Registration => 24,
            self::Career => 72,
        };
    }

    /** Staff can book a date and time against it (appointment, dialysis assessment, interview). */
    public function hasBooking(): bool
    {
        return $this !== self::Enquiry;
    }

    /**
     * The statuses staff can choose for this type. A message has no booking, so no "Booked".
     *
     * @return list<SubmissionStatus>
     */
    public function statuses(): array
    {
        return array_values(array_filter(SubmissionStatus::cases(), fn (SubmissionStatus $s) => $this->hasBooking() || $s !== SubmissionStatus::Booked));
    }

    /** Patient-facing requests that wait on a phone call. */
    public function isPatientCallback(): bool
    {
        return in_array($this, [self::Appointment, self::Dialysis, self::Enquiry], true);
    }
}
