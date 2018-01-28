<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function authenticate(User $user = null, array $overrides = []) : User
    {
        $this->be($user ?: $user = factory(User::class)->create($overrides));

        return $user;
    }
}
