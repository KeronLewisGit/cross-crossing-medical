<?php

namespace App\Support;

use Illuminate\Notifications\Notification as BaseNotification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Throwable;

use function Illuminate\Support\defer;

/**
 * Emails the office and confirms to the patient or applicant. Mail goes out after the response
 * is sent, so a slow or failing mail server never makes anyone wait or lose a submission.
 */
final class Notify
{
    /**
     * Valid addresses for the office (CCMC_NOTIFY_EMAIL) or, with $hr, for job applications
     * (CCMC_NOTIFY_HR_EMAIL, falling back to the office list).
     *
     * @return list<string>
     */
    public static function recipients(bool $hr = false): array
    {
        $valid = fn (array $list) => array_values(array_filter($list, fn (string $a) => (bool) filter_var($a, FILTER_VALIDATE_EMAIL)));
        if ($hr && ($list = $valid(self::configured('notify_hr'))) !== []) {
            return $list;
        }

        return $valid(self::configured('notify'));
    }

    /**
     * Entries in the notify settings that are not email addresses (typos), shown on the dashboard.
     *
     * @return list<string>
     */
    public static function invalid(): array
    {
        $all = array_merge(self::configured('notify'), self::configured('notify_hr'));

        return array_values(array_filter($all, fn (string $a) => ! filter_var($a, FILTER_VALIDATE_EMAIL)));
    }

    /** @return list<string> */
    private static function configured(string $key): array
    {
        return preg_split('/[\s,;]+/', (string) config('ccmc.'.$key), -1, PREG_SPLIT_NO_EMPTY) ?: [];
    }

    public static function office(BaseNotification $notification, bool $hr = false): void
    {
        $to = self::recipients($hr);

        if ($to === []) {
            Log::warning('CCMC_NOTIFY_EMAIL is not set; nobody was emailed about a new submission.', ['notification' => $notification::class]);

            return;
        }

        if ($skipped = self::invalid()) {
            Log::warning('CCMC notify settings have entries that are not email addresses; they were skipped.', ['skipped' => $skipped]);
        }

        defer(function () use ($to, $notification): void {
            try {
                Notification::route('mail', $to)->notify($notification);
            } catch (Throwable $e) {
                report($e);
            }
        });
    }

    /** Confirmation to the sender, when they gave a usable email address. */
    public static function customer(?string $email, BaseNotification $notification): void
    {
        if (! $email || ! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return;
        }

        defer(function () use ($email, $notification): void {
            try {
                Notification::route('mail', $email)->notify($notification);
            } catch (Throwable $e) {
                report($e);
            }
        });
    }
}
