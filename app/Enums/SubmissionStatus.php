<?php

namespace App\Enums;

/**
 * One pipeline for every submission. Labels read naturally per type (a job application is
 * "Interview" where an appointment is "Booked"). Colour is never the only signal: each has an icon.
 */
enum SubmissionStatus: string
{
    case New = 'new';
    case Contacted = 'contacted';
    case Booked = 'booked';
    case Completed = 'completed';
    case Closed = 'closed';

    public function label(?SubmissionType $type = null): string
    {
        return match ([$this, $type]) {
            [self::Contacted, SubmissionType::Career] => 'Reviewing',
            [self::Booked, SubmissionType::Career] => 'Interview',
            [self::Completed, SubmissionType::Career] => 'Hired',
            [self::Closed, SubmissionType::Career] => 'Not taken forward',
            [self::Contacted, SubmissionType::Registration] => 'Checking details',
            [self::Booked, SubmissionType::Registration] => 'First visit booked',
            [self::Completed, SubmissionType::Registration] => 'Registered',
            [self::Contacted, SubmissionType::Dialysis] => 'Called back',
            [self::Booked, SubmissionType::Dialysis] => 'Assessment booked',
            [self::Completed, SubmissionType::Dialysis] => 'Accepted',
            default => match ($this) {
                self::New => 'New',
                self::Contacted => 'Called back',
                self::Booked => 'Booked',
                self::Completed => 'Done',
                self::Closed => 'Closed',
            },
        };
    }

    public function tone(): string
    {
        return match ($this) {
            self::New => 'attention',
            self::Booked => 'info',
            self::Completed => 'good',
            self::Closed => 'muted',
            default => 'neutral',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::New => 'dot',
            self::Contacted => 'phone',
            self::Booked => 'calendar',
            self::Completed => 'check-circle',
            self::Closed => 'x',
        };
    }

    public function isOpen(): bool
    {
        return in_array($this, [self::New, self::Contacted, self::Booked], true);
    }
}
