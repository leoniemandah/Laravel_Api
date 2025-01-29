<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use App\Infrastructure\Admin\Factories\AdminFactory;
use App\Infrastructure\Profile\Factories\ProfileFactory;
use App\Domain\Profile\Services\ProfileServiceInterface;
use App\Infrastructure\Profile\Services\ProfileService;
use Tests\TestCase;

class UpdateProfileTest extends TestCase
{
    use RefreshDatabase;


    private function authenticate()
    {
        // Création d'un utilisateur
        $user = AdminFactory::new()->create();

        // Création d'un token d'authentification pour cet utilisateur
        $token = $user->createToken('admin-token')->plainTextToken;

        // On retourner le token pour l'ajouter dans les headers de la requête
        return $token;
    }

    public function test_delete_profile_requires_authentication()
    {
        //On test le cas où on n'est pas authentifié
        $response = $this->putJson('/api/profile/1');
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }
}
