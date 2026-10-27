<?php

namespace Database\Seeders;

use App\Enums\JobStatus;
use App\Enums\Role;
use App\Enums\SubmissionStatus;
use App\Enums\SubmissionType;
use App\Http\Controllers\FormController;
use App\Models\FileAccess;
use App\Models\JobPosting;
use App\Models\Submission;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

/**
 * Demo data for the pitch and for screenshots. Everything here is invented and marked
 * is_demo: the patients and applicants are fictional people, the ID and insurance cards are
 * drawn with "DEMO" across them, and the vacancies are examples. Never run in production.
 *
 *   php artisan migrate:fresh --seeder=DemoSeeder
 *
 * Logins (password "password"): admin@, frontdesk@, records@ and hr@ccmc.test.
 */
class DemoSeeder extends Seeder
{
    private const array FIRST = ['Aaliyah', 'Kevin', 'Shereen', 'Ravi', 'Nadia', 'Marlon', 'Anjali', 'Dwayne', 'Keisha', 'Sunil', 'Tricia', 'Andre', 'Vashti', 'Rondell', 'Melissa', 'Jason', 'Radha', 'Kerry-Ann', 'Nigel', 'Indira', 'Shaquille', 'Petra', 'Darren', 'Savitri', 'Jerome', 'Chantal', 'Vishnu', 'Stacy-Ann', 'Brandon', 'Gail'];

    private const array LAST = ['Ramdial', 'Joseph', 'Mohammed', 'Charles', 'Persad', 'Baptiste', 'Ali', 'Rampersad', 'Phillip', 'Maharaj', 'Thomas', 'Khan', 'Ramkissoon', 'Alexander', 'Singh', 'Hosein', 'Francis', 'Boodoo', 'Williams', 'Seecharan', 'Mitchell', 'Lalla', 'Paul', 'Ramnarine'];

    private const array TOWNS = ['Cross Crossing', 'Marabella', 'Gasparillo', 'Pleasantville', 'Vistabella', 'La Romaine', 'Gulf View', 'Princes Town', 'Debe', 'Point Fortin', 'Claxton Bay', 'Penal'];

    public function run(): void
    {
        mt_srand(4411);
        Storage::disk('local')->deleteDirectory('submissions');

        $users = [];
        foreach ([
            ['admin@ccmc.test', 'Demo Administrator', Role::Admin],
            ['frontdesk@ccmc.test', 'Demo Front Desk', Role::FrontDesk],
            ['frontdesk2@ccmc.test', 'Second Front Desk', Role::FrontDesk],
            ['records@ccmc.test', 'Demo Records Officer', Role::Records],
            ['hr@ccmc.test', 'Demo HR Officer', Role::Hr],
        ] as [$email, $name, $role]) {
            $users[$email] = User::updateOrCreate(['email' => $email], ['name' => $name, 'password' => Hash::make('password'), 'role' => $role, 'active' => true]);
        }

        $this->call(HandoutSeeder::class);
        $jobs = $this->jobs();

        $plan = array_merge(
            array_fill(0, 58, SubmissionType::Appointment),
            array_fill(0, 22, SubmissionType::Registration),
            array_fill(0, 10, SubmissionType::Dialysis),
            array_fill(0, 14, SubmissionType::Career),
            array_fill(0, 14, SubmissionType::Enquiry),
        );
        shuffle($plan);

        foreach ($plan as $i => $type) {
            // Spread over 30 days, busier recently; the last few are only minutes or hours old.
            // The first six stay new: a few inside their call-back window, a few already late,
            // so the dashboard headline has something to show.
            $fresh = $i < 6;
            $minutesAgo = $fresh ? [14, 38, 75, 165, 250, 330][$i] : (int) (pow(mt_rand(0, 1000) / 1000, 1.4) * 30 * 24 * 60) + 400;
            $created = now()->subMinutes($minutesAgo)->setSecond(0);
            $this->submission($fresh && $i >= 3 ? SubmissionType::Appointment : $type, $created, $users, $jobs, progress: ! $fresh);
        }

        // A few document openings by the records officer, so the log isn't empty.
        $records = $users['records@ccmc.test'];
        Submission::where('type', SubmissionType::Registration)->whereHas('files')->with('files')->latest('id')->limit(6)->get()
            ->each(function (Submission $s) use ($records): void {
                $file = $s->files->first();
                if ($file === null) {
                    return;
                }
                $at = $s->created_at->copy()->addHours(mt_rand(1, 20));
                if ($at->isFuture()) {
                    return;
                }
                FileAccess::create(['submission_file_id' => $file->id, 'submission_id' => $s->id, 'user_id' => $records->id, 'ip' => '10.0.0.'.mt_rand(10, 60)])
                    ->forceFill(['created_at' => $at])->save();
                $s->notes()->create(['user_id' => $records->id, 'kind' => 'access', 'body' => "Opened {$file->label()} ({$file->original_name})."])
                    ->forceFill(['created_at' => $at, 'updated_at' => $at])->save();
            });
    }

    /** @return list<JobPosting> */
    private function jobs(): array
    {
        $rows = [
            ['registered-nurse-inpatient-unit', 'Registered Nurse, Inpatient Unit', 'registered-nurse', 'Inpatient Unit', 'shifts', 'Join the 24-hour nursing team caring for medical admissions and cardiac patients.',
                "Assess, plan and deliver nursing care for admitted patients\nGive medicines and monitor patients on the cardiac care unit\nWork rotating day and night shifts, including weekends\nHand over clearly to the next shift", "Registered with the Nursing Council of Trinidad and Tobago\nAt least two years' acute-care experience\nCurrent BLS certificate (ACLS an advantage)"],
            ['dialysis-nurse', 'Dialysis Nurse', 'dialysis', 'Renal Centre & Dialysis Unit', 'full-time', 'Run haemodialysis sessions for the unit\'s regular patients.',
                "Prepare patients and machines for haemodialysis\nMonitor patients throughout each session\nKeep accurate treatment records", "Registered nurse with renal or dialysis experience, or willing to train\nCareful, calm and good with long-term patients"],
            ['medical-laboratory-technologist', 'Medical Laboratory Technologist', 'lab', 'Laboratory', 'part-time', 'Process and report routine tests in the centre\'s on-site laboratory.',
                "Collect, process and analyse samples\nRun quality control on analysers\nRelease results through the laboratory system", "Degree or diploma in medical laboratory technology\nRegistered with the relevant professional board"],
        ];
        $jobs = [];
        foreach ($rows as [$slug, $title, $role, $dept, $employment, $summary, $duties, $req]) {
            $jobs[] = JobPosting::updateOrCreate(['slug' => $slug], [
                'title' => $title, 'role_key' => $role, 'department' => $dept, 'employment' => $employment,
                'status' => JobStatus::Open, 'summary' => $summary, 'duties' => $duties, 'requirements' => $req,
                'closes_on' => today()->addDays(mt_rand(14, 40)), 'is_demo' => true,
            ]);
        }

        return $jobs;
    }

    /**
     * @param  array<string, User>  $users
     * @param  list<JobPosting>  $jobs
     */
    private function submission(SubmissionType $type, Carbon $created, array $users, array $jobs, bool $progress = true): void
    {
        $first = Arr::random(self::FIRST);
        $last = Arr::random(self::LAST);
        $name = "$first $last";
        $phone = '868-'.Arr::random(['3', '4', '6', '7']).mt_rand(10, 99).'-'.mt_rand(1000, 9999);
        $email = mt_rand(0, 100) < 70 ? strtolower(str_replace([' ', "'"], ['.', ''], $name)).mt_rand(1, 99).'@example.com' : null;
        $forOther = in_array($type, [SubmissionType::Appointment, SubmissionType::Dialysis, SubmissionType::Registration], true) && mt_rand(0, 100) < 25;
        $patient = $forOther ? Arr::random(self::FIRST).' '.$last : $name;
        $dob = now()->subYears($forOther ? mt_rand(3, 88) : mt_rand(19, 80))->subDays(mt_rand(0, 364))->toDateString();
        $patientDetails = $forOther
            ? ['for_whom' => 'other', 'patient_name' => $patient, 'relationship' => Arr::random(['mother', 'father', 'son', 'daughter', 'carer', 'wife', 'husband']), 'patient_dob' => $dob]
            : ['for_whom' => 'self', 'patient_dob' => mt_rand(0, 100) < 80 ? $dob : null];

        $attrs = [
            'type' => $type, 'name' => $name, 'phone' => $phone, 'email' => $type === SubmissionType::Career ? ($email ?? strtolower($first).'@example.com') : $email,
            'contact_pref' => Arr::random(['phone', 'phone', 'phone', 'whatsapp', 'email']), 'consented_at' => $created, 'is_demo' => true,
            'source_url' => url('/'),
        ];
        $files = [];
        switch ($type) {
            case SubmissionType::Appointment:
                $service = Arr::random(array_merge(array_keys((array) ccmc('clinics')), array_keys((array) ccmc('tests')), ['cardiology', 'family-practice', 'dexa', 'ecg', 'lab', 'lab']));
                $attrs += ['service_key' => $service, 'details' => $patientDetails + [
                    'seen_before' => Arr::random(['yes', 'yes', 'no', 'unsure']),
                    'days' => array_values(Arr::random(array_keys((array) ccmc('weekdays')), mt_rand(1, 4))),
                    'window' => Arr::random(array_keys((array) ccmc('time_windows'))),
                    'from_date' => mt_rand(0, 100) < 40 ? $created->copy()->addDays(mt_rand(1, 14))->toDateString() : null,
                    'reason' => Arr::random([null, null, 'Follow-up for blood pressure', 'Annual check-up', 'Knee pain for two months', 'Referred by my GP', 'Bone density scan requested by my doctor', 'Sugar check, last test was high', 'Travel vaccines for a work trip']),
                ]];
                if (mt_rand(0, 100) < 20) {
                    $files['referral'] = ['demo-referral-letter.pdf', $this->pdf('DEMO REFERRAL LETTER', 'Fictional example for the CCMC website demo.')];
                }
                break;
            case SubmissionType::Dialysis:
                $situations = FormController::dialysisSituations();
                $attrs += ['service_key' => 'dialysis', 'message' => Arr::random([null, 'Currently dialysing three times a week, hoping to move closer to home.', 'My father was just told he needs dialysis.']), 'details' => $patientDetails + [
                    'situation' => Arr::random(array_keys($situations)),
                    'current_unit' => Arr::random([null, 'Another unit in South Trinidad', 'Referred by his nephrologist']),
                    'schedule' => Arr::random(array_keys((array) ccmc('dialysis.schedules'))),
                    'shift' => Arr::random(array_keys((array) ccmc('dialysis.shifts'))),
                ]];
                break;
            case SubmissionType::Registration:
                $insured = mt_rand(0, 100) < 55;
                $attrs['name'] = $forOther ? $name : $patient;
                $attrs += ['details' => [
                    'patient_name' => $patient, 'patient_dob' => $dob, 'sex' => Arr::random(['female', 'male', 'unsaid']),
                    'for_whom' => $forOther ? 'other' : 'self', 'relationship' => $forOther ? $patientDetails['relationship'] : null,
                    'address' => mt_rand(2, 140).' '.Arr::random(['Main Road', 'Oliver Avenue', 'Rambert Street', 'Golconda Road', 'Pond Street', 'Hill Drive']),
                    'town' => Arr::random(self::TOWNS), 'id_type' => Arr::random(array_keys(FormController::ID_TYPES)),
                    'insured' => $insured ? 'yes' : 'no', 'insurer' => $insured ? 'Demo Health Insurance Co.' : null,
                    'emergency_name' => Arr::random(self::FIRST).' '.$last, 'emergency_relationship' => Arr::random(['spouse', 'mother', 'brother', 'daughter']),
                    'emergency_phone' => '868-'.mt_rand(300, 799).'-'.mt_rand(1000, 9999), 'reminders' => (bool) mt_rand(0, 1),
                ]];
                if (mt_rand(0, 100) < 75) {
                    $files['id_card'] = ['id-front.jpg', $this->card('NATIONAL ID (DEMO)', $patient, '#dfe7f2')];
                }
                if ($insured && mt_rand(0, 100) < 80) {
                    $files['insurance_card'] = ['insurance-card.jpg', $this->card('HEALTH INSURANCE (DEMO)', $patient, '#f4ead6')];
                }
                break;
            case SubmissionType::Career:
                $job = mt_rand(0, 100) < 70 ? Arr::random($jobs) : null;
                $attrs += ['job_posting_id' => $job?->id, 'service_key' => $job->role_key ?? Arr::random(array_keys((array) ccmc('career_roles'))),
                    'message' => Arr::random([null, 'I have worked night shifts on a medical ward for four years.', 'Recently qualified and keen to learn.']),
                    'details' => [
                        'registration' => mt_rand(0, 100) < 60 ? 'DEMO-'.mt_rand(10000, 99999) : null,
                        'experience' => Arr::random(array_keys(FormController::EXPERIENCE)),
                        'availability' => array_values(Arr::random(array_keys((array) ccmc('availability')), mt_rand(1, 2))),
                        'available_from' => null,
                    ]];
                $files['cv'] = ['cv-'.strtolower($last).'.pdf', $this->pdf("DEMO CV: $name", 'Fictional applicant created for the CCMC website demo.')];
                break;
            case SubmissionType::Enquiry:
                $attrs += ['message' => Arr::random(['Do you do medicals for work permits?', 'Can I get a copy of my lab report sent to my doctor?', 'What are your visiting hours for the inpatient unit?', 'Do you accept my insurance?', 'Is the X-ray department open on Sundays?']),
                    'details' => ['topic' => Arr::random(array_keys(FormController::TOPICS))]];
                break;
        }

        /** @var Submission $s */
        $s = Submission::create($attrs);
        $s->forceFill(['created_at' => $created, 'updated_at' => $created])->saveQuietly();
        $s->forceFill(['reference' => sprintf('%s-%s-%05d', $type->prefix(), $created->format('y'), $s->id)])->saveQuietly();
        $s->notes()->create(['kind' => 'system', 'body' => 'Received from the website'.($s->subject() ? ' about '.$s->subject() : '').'.'])
            ->forceFill(['created_at' => $created, 'updated_at' => $created])->save();

        foreach ($files as $kind => [$original, $bytes]) {
            $path = 'submissions/'.$s->id.'/'.bin2hex(random_bytes(8)).'.'.pathinfo($original, PATHINFO_EXTENSION);
            Storage::disk('local')->put($path, $bytes);
            $s->files()->create(['kind' => $kind, 'path' => $path, 'original_name' => $original, 'mime' => str_ends_with($original, '.pdf') ? 'application/pdf' : 'image/jpeg', 'size' => strlen($bytes)]);
        }

        if ($progress) {
            $this->progress($s, $created, $users);
        }
    }

    /**
     * Move older requests along: called back within a realistic time, then booked or done.
     * A handful of recent ones stay new and late, so the dashboard headline has something to show.
     *
     * @param  array<string, User>  $users
     */
    private function progress(Submission $s, Carbon $created, array $users): void
    {
        $ageHours = $created->diffInHours(now());
        $staff = match ($s->type) {
            SubmissionType::Registration => $users['records@ccmc.test'],
            SubmissionType::Career => $users['hr@ccmc.test'],
            default => Arr::random([$users['frontdesk@ccmc.test'], $users['frontdesk2@ccmc.test']]),
        };
        $window = $s->type->responseHours();
        if ($ageHours < $window * 0.5 || ($ageHours < $window * 4 && mt_rand(0, 100) < 45)) {
            return; // still new (late if older than its window)
        }
        $contactedAt = $created->copy()->addMinutes(mt_rand(6, (int) ($window * 60 * 1.3)));
        if ($contactedAt->isFuture()) {
            return;
        }
        $s->assigned_to = $staff->id;
        $s->first_contacted_at = $contactedAt;
        $s->status = SubmissionStatus::Contacted;
        $note = match ($s->type) {
            SubmissionType::Appointment => Arr::random(['Called back. Patient prefers the earliest morning clinic.', 'Spoke to the patient, checking the clinic diary.', 'No answer first time; reached on second call.']),
            SubmissionType::Dialysis => 'Spoke to the family about an initial examination and review.',
            SubmissionType::Registration => 'Details checked against the ID. File opened.',
            SubmissionType::Career => 'CV reviewed.',
            SubmissionType::Enquiry => 'Replied by phone.',
        };
        $s->notes()->create(['user_id' => $staff->id, 'kind' => 'note', 'body' => $note])->forceFill(['created_at' => $contactedAt, 'updated_at' => $contactedAt])->save();

        $roll = mt_rand(0, 100);
        if ($s->type === SubmissionType::Enquiry) {
            $s->status = $roll < 80 ? SubmissionStatus::Completed : SubmissionStatus::Contacted;
        } elseif ($s->type === SubmissionType::Registration) {
            $s->status = $roll < 60 ? SubmissionStatus::Completed : ($roll < 80 ? SubmissionStatus::Booked : SubmissionStatus::Contacted);
        } elseif ($roll < 70) {
            // Booked: a date from a few days after arrival, so some fall in the next fortnight.
            $date = $created->copy()->addDays(mt_rand(1, 16))->startOfDay();
            $s->booked_date = $date;
            $s->booked_time = sprintf('%02d:%02d', mt_rand(8, 17), Arr::random([0, 15, 30, 45]));
            $s->status = $date->isPast() && $roll < 55 ? SubmissionStatus::Completed : SubmissionStatus::Booked;
            if ($s->type === SubmissionType::Career && $roll < 25) {
                $s->status = SubmissionStatus::Closed;
            }
        } elseif ($roll < 80) {
            $s->status = SubmissionStatus::Closed;
        }
        $s->status_changed_at = $contactedAt;
        $s->saveQuietly();
    }

    /** A clearly fake ID or insurance card, drawn with GD. */
    private function card(string $title, string $name, string $bg): string
    {
        $im = imagecreatetruecolor(640, 400);
        [$r, $g, $b] = sscanf($bg, '#%02x%02x%02x');
        imagefill($im, 0, 0, (int) imagecolorallocate($im, (int) $r, (int) $g, (int) $b));
        $ink = (int) imagecolorallocate($im, 20, 40, 80);
        $red = (int) imagecolorallocatealpha($im, 192, 39, 29, 70);
        imagefilledrectangle($im, 0, 0, 640, 64, $ink);
        imagestring($im, 5, 24, 24, $title, (int) imagecolorallocate($im, 255, 255, 255));
        imagefilledrectangle($im, 32, 100, 192, 300, (int) imagecolorallocate($im, 180, 190, 205));
        imagestring($im, 5, 220, 120, 'NAME: '.strtoupper($name), $ink);
        imagestring($im, 4, 220, 160, 'NO: DEMO-'.mt_rand(100000, 999999), $ink);
        imagestring($im, 4, 220, 190, 'NOT A REAL DOCUMENT', $ink);
        imagestring($im, 3, 24, 370, 'Fictional sample for the Cross Crossing Medical Centre website demo', $ink);
        for ($i = 0; $i < 12; $i++) {
            imagestring($im, 5, 40 + $i * 48, 220 + (int) (sin($i) * 20), 'DEMO', $red);
        }
        ob_start();
        imagejpeg($im, null, 80);

        return (string) ob_get_clean();
    }

    /** A one-page PDF with two lines of text. */
    private function pdf(string $title, string $line): string
    {
        $esc = fn (string $t) => str_replace(['\\', '(', ')'], ['\\\\', '\\(', '\\)'], $t);
        $stream = "BT /F1 20 Tf 72 740 Td ({$esc($title)}) Tj ET\nBT /F1 12 Tf 72 712 Td ({$esc($line)}) Tj ET";
        $objects = [
            '<< /Type /Catalog /Pages 2 0 R >>',
            '<< /Type /Pages /Kids [3 0 R] /Count 1 >>',
            '<< /Type /Page /Parent 2 0 R /MediaBox [0 0 612 792] /Contents 4 0 R /Resources << /Font << /F1 5 0 R >> >> >>',
            '<< /Length '.strlen($stream)." >>\nstream\n$stream\nendstream",
            '<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>',
        ];
        $out = "%PDF-1.4\n";
        $offsets = [];
        foreach ($objects as $i => $obj) {
            $offsets[] = strlen($out);
            $out .= ($i + 1)." 0 obj\n$obj\nendobj\n";
        }
        $xref = strlen($out);
        $out .= 'xref'."\n0 ".(count($objects) + 1)."\n0000000000 65535 f \n";
        foreach ($offsets as $o) {
            $out .= sprintf("%010d 00000 n \n", $o);
        }

        return $out.'trailer << /Size '.(count($objects) + 1)." /Root 1 0 R >>\nstartxref\n$xref\n%%EOF\n";
    }
}
