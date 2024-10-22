<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class SanctumTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;
    public function test_user_login(): void
    {
        $user = User::factory()->create([
            'email' => 'dissaor@gmail.com',
            'name' => 'Dissaor'
        ]);
        $response = $this->post('/api/login', [
            'email' => 'dissaor@gmail.com',
            'password' => 'password'
        ]);

        //$response->assertStatus(200);
        $response->assertJsonStructure([
            'user' => ['email', 'name'],
            'token'
        ]);
    }
}
