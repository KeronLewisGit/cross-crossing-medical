<?php

namespace App\Enums;

enum JobStatus: string
{
    case Draft = 'draft';
    case Open = 'open';
    case Closed = 'closed';

    public function label(): string
    {
        return match ($this) {
            self::Draft => 'Draft',
            self::Open => 'Open',
            self::Closed => 'Closed',
        };
    }

    public function tone(): string
    {
        return match ($this) {
            self::Open => 'good',
            self::Draft => 'neutral',
            self::Closed => 'muted',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::Open => 'check-circle',
            self::Draft => 'pencil',
            self::Closed => 'x',
        };
    }
}
