<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_about_page_loads_successfully(): void
    {
        $response = $this->get('/about');
        $response->assertStatus(200);
        $response->assertSee('Tentang Aplikasi Job Portal');
    }

    public function test_login_page_renders(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSee('Login');
    }

    public function test_register_page_renders(): void
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
        $response->assertSee('Form Register');
    }

    public function test_user_can_register(): void
    {
        $response = $this->post('/register', [
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHas('success', 'Registrasi berhasil! Silakan login.');
        $this->assertDatabaseHas('users', ['email' => 'budi@example.com']);
    }

    public function test_user_cannot_register_with_mismatched_password(): void
    {
        $response = $this->post('/register', [
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'password' => 'password123',
            'password_confirmation' => 'berbeda456',
        ]);

        $response->assertSessionHasErrors(['password']);
    }

    public function test_user_can_login_and_access_dashboard(): void
    {
        $user = User::create([
            'name' => 'HR Admin - PT Teknologi',
            'email' => 'admin@jobportal.com',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->post('/login', [
            'email' => 'admin@jobportal.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($user);

        $dashResponse = $this->actingAs($user)->get('/dashboard');
        $dashResponse->assertStatus(200);
        $dashResponse->assertSee("logged in!");
        $dashResponse->assertSee('HR Admin - PT Teknologi');
    }

    public function test_guest_is_redirected_from_dashboard(): void
    {
        $response = $this->get('/dashboard');
        $response->assertRedirect('/login');
    }

    public function test_user_can_logout(): void
    {
        $user = User::create([
            'name' => 'Job Seeker',
            'email' => 'seeker@jobportal.com',
            'password' => Hash::make('password123'),
        ]);

        $this->actingAs($user);
        $response = $this->post('/logout');
        $response->assertRedirect('/login');
        $this->assertGuest();
    }
}
