<?php

namespace Tests;

use App\Models\User;
use Laravel\Passport\Passport;

abstract class PassportAdminTestCase extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();
        $user->roles()->sync(2);
        Passport::actingAs($user, ['BlogApp']);
    }
}