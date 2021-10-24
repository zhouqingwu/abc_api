<?php

namespace Tests;

use App\Models\User;
use Laravel\Sanctum\Sanctum;
use App\Models\PurchaseTransaction;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use WithFaker;
    public function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
    }

    public function createUser($args = [])
    {
        return User::factory()->create($args);
    }

    public function authUser()
    {
        $user = $this->createUser();
        Sanctum::actingAs($user);
        return $user;
    }

    public function createPurchaseTransaction($args = [])
    {
        return PurchaseTransaction::factory()->create($args);
    }
}
