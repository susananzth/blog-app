<?php

namespace Tests;

use App\Models\User;
use Laravel\Passport\Passport;

abstract class PassportAdminTestCase extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('passport:install', ['--no-interaction' => true, '--force' => true,]);
    }
}