<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;
use Carbon\Carbon;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;


    public function test_user_cannot_register_with_invalid_data()
    {
        $response = $this->post('/register', [
            'firstname' => '',
            'lastname' => '',
            'email' => 'not-an-email',
            'password' => 'short',
            'password_confirmation' => 'different',
        ]);

        $response->assertSessionHasErrors(['first_name', 'last_name', 'email', 'password']);
    }

    public function test_user_can_login_and_redirects_to_dashboard()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('secret123'),
            'password_changed_at' => now(),
        ]);

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'secret123',
        ]);

        $response->assertRedirect('dashboard');
        $this->assertAuthenticatedAs($user);
    }

    public function test_user_with_old_password_is_redirected_to_change_form()
    {
        $user = User::factory()->create([
            'email' => 'old@example.com',
            'password' => Hash::make('oldpassword'),
            'password_changed_at' => Carbon::now()->subDays(31),
        ]);

        $response = $this->post('/login', [
            'email' => 'old@example.com',
            'password' => 'oldpassword',
        ]);

        $response->assertRedirect(route('password.change.form'));
        $response->assertSessionHas('status');
    }

    public function test_user_cannot_login_with_invalid_credentials()
{
    $user = User::factory()->create([
        'email' => 'fail@example.com',
        'password' => bcrypt('correct'),
    ]);

    $response = $this->post('/login', [
        'email' => 'fail@example.com',
        'password' => 'wrong',
    ]);

    // Zamiast sprawdzać błędy walidacji, sprawdź sesję "error"
    $response->assertSessionHas('error', 'Nieprawidłowy email lub hasło.');
    $this->assertGuest();
}


    public function test_user_can_logout()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post('/logout')
            ->assertRedirect(route('home'));

        $this->assertGuest();
    }
}
