<?php

namespace Tests\Feature;

use App\Domain\Profile\Models\Profile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use App\Infrastructure\Admin\Factories\AdminFactory;
use App\Infrastructure\Profile\Factories\ProfileFactory;
use Tests\TestCase;

class GetByIdProfileTest extends TestCase
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


    public function test_get_profile_by_id_with_authentication()
    {
        $profile = ProfileFactory::new()->create();

        $token = $this->authenticate();

        $response = $this->getJson('/api/profile/' . $profile->id, [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(Response::HTTP_OK);
        // On vérifie que le profil retourne bien le status
        $response->assertJsonFragment([
            'id' => $profile->id,
            'status' =>  $profile->status == "en_attente" ? "en attente" : $profile->status
        ]);
    }

    public function test_get_profile_by_id_without_authentication()
    {
        $profile = ProfileFactory::new()->create(['status' => 'actif']);

        $response = $this->getJson('/api/profile/' . $profile->id);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonFragment([
            'id' => $profile->id,
        ]);

        // Récupère les données du profil depuis la réponse JSON
        $data = $response->json('data');

        // Vérifie que le champ 'status' est manquant dans la réponse pour les utilisateurs non authentifiés
        $this->assertArrayNotHasKey('status', $data);
    }

    public function test_get_profile_by_id_404_if_not_found()
    {
        // On vérifie que dans le cas ou on ne trouve pas de profil on renvoie bien une 404
        $response = $this->getJson('/api/profile/78');
        $response->assertStatus(Response::HTTP_NOT_FOUND);
        $response->assertJson([
            'message' => 'Aucun profil existant pour cet id.',
        ]);
    }
}
