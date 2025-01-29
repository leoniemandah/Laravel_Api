<?php

namespace Tests\Feature;

use App\Domain\Admin\Models\Admin;
use App\Domain\Profile\Models\Profile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use App\Infrastructure\Admin\Factories\AdminFactory;
use App\Infrastructure\Profile\Factories\ProfileFactory;
use App\Domain\Profile\Services\ProfileServiceInterface;
use App\Infrastructure\Profile\Services\ProfileService;
use Tests\TestCase;

class DeleteProfileTest extends TestCase
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
        $response = $this->deleteJson('/api/profile/1');
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function testDeleteProfile()
    {
        // On récupère le token
        $token = $this->authenticate();

        // On crée un profil fictif pour tester la suppression
        $profile = ProfileFactory::new()->create();

        // On appelle la méthode de suppression
        // On tente de supprimer un profil inexistant
        $response = $this->deleteJson('api/profile/' . $profile->id, [], [
            'Authorization' => 'Bearer ' . $token,
        ]);
        // On vérifie que le profil a bien été supprimé
        $this->assertDatabaseMissing('profiles', ['id' => $profile->id]);

        // On vérifie la réponse HTTP
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson([
            'message' => 'Le profil a bien été supprimé.',
        ]);
    }

    public function testDeleteProfileNotFound()
    {

        // On récupère le token
        $token = $this->authenticate();

        // On tente de supprimer un profil inexistant
        $response = $this->deleteJson('api/profile/37', [], [
            'Authorization' => 'Bearer ' . $token,
        ]);
        // On vérifie la réponse pour un profil non trouvé
        $response->assertStatus(Response::HTTP_NOT_FOUND);
        $response->assertJson([
            'message' => 'Aucun profil existant pour cet id.',
        ]);
    }
}
