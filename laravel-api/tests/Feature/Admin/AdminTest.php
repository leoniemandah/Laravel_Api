<?php

namespace Tests\Unit;

use App\Domain\Admin\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use App\Infrastructure\Admin\Factories\AdminFactory;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_requires_email_and_password()
    {
        // On essaie de se connecter sans mot de passe
        $response = $this->postJson('/api/admin/login', [
            'email' => 'admin@example.com',
        ]);

        // On vérifie que la réponse contient une erreur de validation
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(['password']);
    }

    public function test_login_fails_with_invalid_email_format()
    {
        //On test avec un mot de passe invalide
        $response = $this->postJson('/api/admin/login', [
            'email' => 'not-an-email',
            'password' => 'password',
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(['email']);
    }
}
