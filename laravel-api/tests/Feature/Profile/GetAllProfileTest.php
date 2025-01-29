<?php

namespace Tests\Feature;

use App\Domain\Profile\Models\Profile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use App\Infrastructure\Admin\Factories\AdminFactory;
use App\Infrastructure\Profile\Factories\ProfileFactory;
use App\Domain\Profile\Services\ProfileServiceInterface;
use App\Infrastructure\Profile\Services\ProfileService;
use Tests\TestCase;

class GetAllProfileTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Création de profils avec différents statuts
        ProfileFactory::new()->count(2)->create(['status' => 'actif']);
        ProfileFactory::new()->count(4)->create(['status' => 'inactif']);
        ProfileFactory::new()->count(5)->create(['status' => 'en_attente']);
    }

   
    private function authenticate()
    {
        // Création d'un utilisateur
        $user = AdminFactory::new()->create();

        // Création d'un token d'authentification pour cet utilisateur
        $token = $user->createToken('admin-token')->plainTextToken;

        // On retourner le token pour l'ajouter dans les headers de la requête
        return $token;
    }

    public function test_can_get_all_profiles_with_authentication()
    {

        //On test qu'un utilisateur authentifié retourne bien le status et récupère tous les profils
        $token = $this->authenticate();
        $response = $this->getJson('/api/profile', [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonCount(10, 'data');

        foreach ($response->json('data') as $profile) {
            $this->assertArrayHasKey('status', $profile); // On vérifie que 'status' est présent
        }
    }

    public function test_can_filter_profiles_by_last_name()
    {
        // Profil avec un nom spécifique pour le test de filtre
        ProfileFactory::new()->create(['lastName' => 'TestLastName', 'status' => 'actif']);

        $response = $this->getJson('/api/profile?lastName=TestLastName');

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonCount(1, 'data');
        $response->assertJsonFragment(['lastName' => 'TestLastName']);
    }

    public function test_can_paginate_profiles()
    {
        // On simule une pagination avec une limite de 3 profils par page
        $token = $this->authenticate();

        $response = $this->getJson('/api/profile?limit=3', [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonCount(3, 'data'); // 3 profils dans la page de résultats
        $response->assertJsonStructure([
            'data',
            'links' => [
                'first',
                'last',
                'prev',
                'next',
            ],
            'meta' => [
                'current_page',
                'last_page',
                'from',
                'to',
                'total',
            ],
        ]);
    }
}
