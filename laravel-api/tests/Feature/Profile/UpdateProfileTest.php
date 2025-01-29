<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use App\Infrastructure\Admin\Factories\AdminFactory;
use App\Infrastructure\Profile\Factories\ProfileFactory;
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

    public function testUpdateProfile()
    {
        // On récupère le token d'authentification
        $token = $this->authenticate();

        // On crée un profil fictif pour tester la mise à jour
        $profile = ProfileFactory::new()->create();

        // On prépare les données pour la mise à jour
        $data = [
            'lastName' => 'NouveauNom',
            'firstName' => 'NouveauPrenom',
            'status' => 'actif',
            // Ajoute éventuellement un fichier image si nécessaire
            'image' => null,
        ];

        // On effectue la requête PUT pour la mise à jour du profil
        $response = $this->putJson('api/profile/' . $profile->id, $data, [
            'Authorization' => 'Bearer ' . $token,
        ]);

        // On vérifie la réponse HTTP
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson([
            'message' => 'Le profil a bien été modifié.',
        ]);

        // On vérifie que les données ont bien été mises à jour dans la base
        $this->assertDatabaseHas('profiles', [
            'id' => $profile->id,
            'lastName' => 'NouveauNom',
            'firstName' => 'NouveauPrenom',
            'status' => 'actif',
        ]);
    }

    public function testUpdateProfileNotFound()
    {
        // On récupère le token d'authentification
        $token = $this->authenticate();

        // On tente de mettre à jour un profil inexistant
        $data = [
            'lastName' => 'NomInexistant',
            'firstName' => 'PrenomInexistant',
            'status' => 'actif',
        ];

        // On effectue la requête PUT pour un profil inexistant
        $response = $this->putJson('api/profile/789', $data, [
            'Authorization' => 'Bearer ' . $token,
        ]);

        // On vérifie la réponse pour un profil non trouvé
        $response->assertStatus(Response::HTTP_NOT_FOUND);
        $response->assertJson([
            'message' => 'Aucun profil existant pour cet id.',
        ]);
    }
}
