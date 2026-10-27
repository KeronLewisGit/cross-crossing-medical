<?php

namespace App\Notifications;

use App\Models\Submission;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * To the centre: something new to act on. Only the reference, the type, the name and the
 * clinic travel by email; reasons, dates of birth, insurers and documents stay in the back office.
 */
class NewSubmission extends Notification
{
    public function __construct(public readonly Submission $submission) {}

    /** @return list<string> */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $s = $this->submission;
        $hours = $s->type->responseHours();
        $mail = (new MailMessage)
            ->subject("{$s->type->label()} {$s->reference}")
            ->line("{$s->type->label()} from {$s->name}.");

        if ($about = $s->subject()) {
            $mail->line('About: '.$about);
        }

        return $mail
            ->line('Details and any documents are in the back office only. Please '.($s->type->isPatientCallback() ? 'call back' : 'review it').' within '.$hours.' '.($hours === 1 ? 'hour' : 'hours').'.')
            ->action('Open '.$s->reference, route('admin.submissions.show', $s));
    }
}
