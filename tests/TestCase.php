<?php

namespace Tests;

use App\Enums\Role;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Setting::flush();
    }

    protected function staff(Role $role): User
    {
        return User::factory()->role($role)->create();
    }
}
