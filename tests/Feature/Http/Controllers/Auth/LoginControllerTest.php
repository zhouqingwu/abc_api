<?php

namespace Tests\Feature\Http\Controllers\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_login()
    {
        $user = $this->createUser();

        $response = $this->postJson(route('auth.login'), [
            'email' => $user->email,
            'password' => 'password'
        ])->assertOk();

        $this->assertArrayHasKey('token', $response->json());
    }

    public function test_if_email_is_not_available_then_it_return_error()
    {
        $this->postJson(route('auth.login'), [
            'email' => 'a@b.com',
            'password' => 'password'
        ])->assertUnauthorized();
    }

    public function test_raise_error_if_password_is_incorrect()
    {
        $user = $this->createUser();

        $this->postJson(route('auth.login'), [
            'email' => $user->email,
            'password' => 'random'
        ])->assertUnauthorized();
    }
}
