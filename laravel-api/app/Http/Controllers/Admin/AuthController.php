<?php

namespace App\Http\Controllers\Admin;

use App\Domain\Admin\Services\AdminService;
use App\Http\Requests\Admin\LoginRequest;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

/**
 * Contrôleur d'authentification pour les administrateurs.
 * Gère les opérations de connexion et de déconnexion.
 */
class AuthController extends Controller
{
    /**
     * Instance du service d'administration.
     *
     * @var AdminService
     */
    private AdminService $adminService;

    /**
     * Constructeur du contrôleur.
     *
     * @param AdminService $adminService Service injecté pour gérer la logique métier des administrateurs.
     */
    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    /**
     * Gère la connexion d'un administrateur et retourne un token d'accès.
     *
     * @param LoginRequest $request Requête validée contenant les informations de connexion (email et mot de passe).
     * @return JsonResponse Réponse contenant le token d'accès ou un message d'erreur en cas d'échec.
     */
    public function login(LoginRequest $request): JsonResponse
    {
        // Récupère les informations de connexion validées (email et mot de passe).
        $credentials = $request->validated();

        // Vérifie si les informations de connexion sont valides.
        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Invalid credentials'], 401); // Retourne une erreur 401 si les identifiants sont incorrects.
        }

        // Récupère l'administrateur correspondant à l'email fourni.
        $admin = $this->adminService->findAdminByEmail($credentials['email']);

        // Génère un token d'accès pour l'administrateur authentifié.
        $token = $admin->createToken('auth_token')->plainTextToken;

        // Retourne le token d'accès avec son type (Bearer).
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], 200);
    }

    /**
     * Gère la déconnexion d'un administrateur et révoque le token d'accès.
     *
     * @return JsonResponse Réponse confirmant la déconnexion ou une erreur si aucun utilisateur n'est authentifié.
     */
    public function logout(): JsonResponse
    {
        // Vérifie si un utilisateur est actuellement authentifié.
        if (Auth::check()) {
            // Supprime tous les tokens associés à l'utilisateur authentifié.
            Auth::user()->tokens()->delete();

            // Retourne un message confirmant la déconnexion avec un code 200 (OK).
            return response()->json(['message' => 'Logged out successfully'], 200);
        }

        // Si aucun utilisateur n'est authentifié, retourne une erreur 401 (Unauthorized).
        return response()->json(['message' => 'No authenticated user'], 401);
    }
}
