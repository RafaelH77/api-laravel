<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use WithFaker;

    public function test_register_return_success()
    {
        $data = [
            "name" => $this->faker->firstName,
            "email" => $this->faker->email,
            "password" => $this->faker->password
        ];

        $response = $this->postJson('/api/register', $data);

        $response->assertStatus(200);

        return $data;
    }

    /**
     * @depends test_register_return_success
     */
    public function test_login_return_success($data)
    {
        $response = $this->postJson('/api/login', ["email" => $data['email'], "password" => $data['password']]);

        $response->assertStatus(200);

        return $response['token'];
    }

    /**
     * @depends test_login_return_success
     */
    public function test_token_return_success($token): void
    {
        $response = $this->get('/api/me',
            [
                'Authorization' => "Bearer " . $token
            ]);

        $response->assertStatus(200);
    }
}
