<?php

namespace App\Enums;

enum Role: string
{
    case Admin = 'admin';
    case FrontDesk = 'front_desk';
    case Records = 'records';
    case Hr = 'hr';

    public function label(): string
    {
        return match ($this) {
            self::Admin => 'Administrator',
            self::FrontDesk => 'Front desk & appointments',
            self::Records => 'Registration & medical records',
            self::Hr => 'Human resources',
        };
    }

    /**
     * Submission types this role works in the inbox.
     *
     * @return list<SubmissionType>
     */
    public function types(): array
    {
        return match ($this) {
            self::Admin => SubmissionType::cases(),
            self::FrontDesk => [SubmissionType::Appointment, SubmissionType::Dialysis, SubmissionType::Enquiry],
            self::Records => [SubmissionType::Registration],
            self::Hr => [SubmissionType::Career],
        };
    }

    /**
     * The types behind the dashboard's headline number: the thing this role must act on first.
     *
     * @return list<SubmissionType>
     */
    public function headlineTypes(): array
    {
        return match ($this) {
            self::Admin, self::FrontDesk => [SubmissionType::Appointment, SubmissionType::Dialysis, SubmissionType::Enquiry],
            self::Records => [SubmissionType::Registration],
            self::Hr => [SubmissionType::Career],
        };
    }

    public function headline(): string
    {
        return match ($this) {
            self::Admin, self::FrontDesk => 'patient requests not called back in time',
            self::Records => 'registrations not checked within a day',
            self::Hr => 'applications not reviewed within 3 days',
        };
    }
}
