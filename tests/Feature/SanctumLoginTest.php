<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class SanctumLoginTest extends TestCase
{
    use RefreshDatabase;

    public function testSanctumCsrfCookie(): void
    {
        $response = $this->get('/sanctum/csrf-cookie');

        $response->assertStatus(204);
    }

    public function testSanctumLogin(): void
    {
        $user = User::factory()->make([
            'email' => 'email@inexistente.es',
            'password' => Hash::make('password'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => $user->password,
        ]);

        $response->assertStatus(401);

        $user = User::factory()->make([
            'email' => config('local.testing.user.email'),
            'password' => Hash::make((string) config('local.testing.user.password')),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => config('local.testing.user.email'),
            'password' => config('local.testing.user.password'),
        ]);

        $response->assertStatus(200);
    }

    public function testSanctumRoute(): void
    {
        $user = User::find(config('local.testing.user.id'));

        $response = $this->actingAs($user)->get('/api/user');

        $response->assertStatus(200)->assertJson([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ]);
    }
}
