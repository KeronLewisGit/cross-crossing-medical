<?php

namespace App\Notifications;

use App\Enums\SubmissionType;
use App\Models\Submission;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/** To the patient or applicant: we have it, here is the reference, here is what happens next. */
class SubmissionReceived extends Notification
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
        $phone = format_phone(main_phone());
        $mail = (new MailMessage)
            ->subject("Cross Crossing Medical Centre: your {$this->what()} ({$s->reference})")
            ->greeting('Thank you, '.strtok($s->name, ' ').'.')
            ->line("We have your {$this->what()}. Your reference is **{$s->reference}**.");

        // The clinic or test is health information, so it is not repeated here.
        if ($s->type === SubmissionType::Appointment) {
            $mail->line('This is a request: the appointment is only booked once we have called you to agree a time.');
        }

        $mail->line(match ($s->type) {
            SubmissionType::Appointment => 'Our appointments team will call you back to offer a day and time.',
            SubmissionType::Registration => 'Our registration team will check your details before your first visit. Please bring your ID and insurance card with you.',
            SubmissionType::Dialysis => 'The dialysis unit will call you to talk about an initial examination and review by our physicians.',
            SubmissionType::Career => 'Our human resources team will review your application and contact you if your experience matches a role.',
            SubmissionType::Enquiry => 'A member of our team will reply as soon as possible.',
        });

        if ($s->type !== SubmissionType::Career) {
            $mail->line('**Not for emergencies.** If you are unwell now, come straight to our 24-hour emergency room or call '.ccmc('ambulance').' for an ambulance.');
        }

        return $mail
            ->line("Questions? Call {$phone}. We are open 24 hours a day, every day.")
            ->salutation('Cross Crossing Medical Centre, Oliver Avenue, San Fernando');
    }

    private function what(): string
    {
        return match ($this->submission->type) {
            SubmissionType::Appointment => 'appointment request',
            SubmissionType::Registration => 'new-patient registration',
            SubmissionType::Dialysis => 'dialysis enquiry',
            SubmissionType::Career => 'job application',
            SubmissionType::Enquiry => 'message',
        };
    }
}
