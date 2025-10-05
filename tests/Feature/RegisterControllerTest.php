<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RegisterControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_register_with_valid_data()
    {
        $response = $this->post('/register', [
            'first_name' => 'Anna',
            'last_name' => 'Nowak',
            'email' => 'anna@example.com',
            'password' => 'secure123',
            'password_confirmation' => 'secure123',
            'is_doctor' => 'on', // checkbox
        ]);

        $response->assertRedirect(route('dashboard'));

        $this->assertDatabaseHas('users', [
            'email' => 'anna@example.com',
            'first_name' => 'Anna',
            'last_name' => 'Nowak',
            'role' => 'lekarz',
        ]);

        $this->assertAuthenticated();
    }

    /** @test */
    public function registration_fails_if_data_is_missing()
    {
        $response = $this->from('/register')->post('/register', []);

        $response->assertRedirect('/register');
        $response->assertSessionHasErrors([
            'first_name', 'last_name', 'email', 'password', 'is_doctor'
        ]);

        $this->assertGuest(); // użytkownik nie powinien być zalogowany
    }

    /** @test */
    public function registration_fails_if_is_doctor_not_accepted()
    {
        $response = $this->from('/register')->post('/register', [
            'first_name' => 'Anna',
            'last_name' => 'Nowak',
            'email' => 'anna@example.com',
            'password' => 'secure123',
            'password_confirmation' => 'secure123',
            // brak 'is_doctor'
        ]);

        $response->assertRedirect('/register');
        $response->assertSessionHasErrors('is_doctor');

        $this->assertDatabaseMissing('users', [
            'email' => 'anna@example.com',
        ]);
    }

    /** @test */
    public function user_cannot_register_with_existing_email()
    {
        User::factory()->create(['email' => 'anna@example.com']);

        $response = $this->from('/register')->post('/register', [
            'first_name' => 'Anna',
            'last_name' => 'Nowak',
            'email' => 'anna@example.com',
            'password' => 'secure123',
            'password_confirmation' => 'secure123',
            'is_doctor' => 'on',
        ]);

        $response->assertRedirect('/register');
        $response->assertSessionHasErrors('email');
    }
}

