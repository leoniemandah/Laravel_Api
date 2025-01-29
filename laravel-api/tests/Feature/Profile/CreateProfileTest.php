<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use App\Infrastructure\Admin\Factories\AdminFactory;
use App\Domain\Profile\Services\ProfileServiceInterface;
use App\Infrastructure\Profile\Services\ProfileService;
use Tests\TestCase;

class CreateProfileTest extends TestCase
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

    public function test_create_profile_requires_authentication()
    {
        //On test le cas où on n'est pas authentifié
        $response = $this->postJson('/api/profile');
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function test_store_requires_lastname()
    {

        // On récupère le token
        $token = $this->authenticate();
        //On créer une requête sans le champ lastName
        $data = [
            'firstName' => 'John',
            'image' => UploadedFile::fake()->image('profile.jpg'),
            'status' => 'actif',
        ];

        //On appele l'API pour créer le profil
        $response = $this->postJson('/api/profile', $data, [
            'Authorization' => 'Bearer ' . $token,
        ]);

        //On vérifie que la réponse est 422 Unprocessable Entity
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        //On vérifie que l'erreur est renvoyée pour le champ lastName
        $response->assertJsonValidationErrors(['lastName']);
    }

    public function test_store_requires_valid_image()
    {

        // On récupère le token
        $token = $this->authenticate();

        //On créer une requête avec un fichier non image
        $data = [
            'lastName' => 'Doe',
            'firstName' => 'John',
            'image' => UploadedFile::fake()->create('file.txt', 1024), // Non image
            'status' => 'actif',
        ];

        //On appeler l'API pour créer le profil
        $response = $this->postJson('/api/profile', $data, [
            'Authorization' => 'Bearer ' . $token,
        ]);

        //On vérifie que la réponse est 422 Unprocessable Entity
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        // On vérifie que l'erreur est renvoyée pour l'image
        $response->assertJsonValidationErrors(['image']);
    }


    public function test_store_requires_valid_status()
    {

        // On récupère le token
        $token = $this->authenticate();

        // On créer une requête avec un statut invalide
        $data = [
            'lastName' => 'Doe',
            'firstName' => 'John',
            'image' => UploadedFile::fake()->image('profile.jpg'),
            'status' => 'invalid_status', // Statut invalide
        ];

        // On appele l'API pour créer le profil
        $response = $this->postJson('/api/profile', $data, [
            'Authorization' => 'Bearer ' . $token,
        ]);

        // On vérifie que la réponse est 422 Unprocessable Entity
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        // On vérifie que l'erreur est renvoyée pour le statut
        $response->assertJsonValidationErrors(['status']);
    }
}
