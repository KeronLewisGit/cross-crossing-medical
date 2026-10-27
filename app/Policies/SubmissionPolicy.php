<?php

namespace App\Policies;

use App\Enums\Role;
use App\Enums\SubmissionType;
use App\Models\Submission;
use App\Models\SubmissionFile;
use App\Models\User;

class SubmissionPolicy
{
    /** Each role sees the types it works (Role::types); administrators see all. */
    public function view(User $user, Submission $submission): bool
    {
        return $user->canWork($submission->type);
    }

    public function update(User $user, Submission $submission): bool
    {
        return $user->canWork($submission->type);
    }

    /** Date of birth, address, ID number type and insurer on a registration. */
    public function viewPersonalDetails(User $user, Submission $submission): bool
    {
        return $submission->type === SubmissionType::Registration && $user->hasRole(Role::Records, Role::Admin);
    }

    /**
     * ID and insurance cards open for the registration & records role only, not even for
     * administrators. Other uploads (referral letters, CVs) follow view().
     */
    public function openFile(User $user, Submission $submission, SubmissionFile $file): bool
    {
        if ($file->submission_id !== $submission->id) {
            return false;
        }
        if ($file->isRestricted()) {
            return $user->role === Role::Records;
        }

        return $this->view($user, $submission);
    }
}
