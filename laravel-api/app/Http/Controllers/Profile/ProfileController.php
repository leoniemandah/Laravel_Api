<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\ProfileRequest;
use App\Http\Resources\Profile\ProfileResource;
use App\Domain\Profile\Services\ProfileServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProfileController extends Controller
{
    protected ProfileServiceInterface $profileService;

    public function __construct(ProfileServiceInterface $profileService)
    {
        $this->profileService = $profileService;
    }

    public function index(Request $request)
    {
        try {
            return ProfileResource::collection($this->profileService->getAllProfile($request));
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Un problème est survenu lors de la récupération des profils.',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(ProfileRequest $request)
    {
        try {
            $profileDTO = $request->toDTO();
            $this->profileService->createProfile($profileDTO, $request->file('image'));
            return response()->json(['message' => 'Le profil a bien été créé.'], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Une erreur est survenue.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show(string $id)
    {
        try {
            return new ProfileResource($this->profileService->getProfileById($id));
        } catch (NotFoundHttpException $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Une erreur est survenue.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(ProfileRequest $request, string $id)
    {
        try {
            $profileDTO = $request->toDTO();
            $image = $request->hasFile('image') ? $request->file('image') : null;
            $this->profileService->updateProfile($profileDTO, $id, $image);

            return response()->json(['message' => 'Le profil a bien été modifié.'], Response::HTTP_OK);
        } catch (NotFoundHttpException $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Une erreur est survenue.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    

    public function destroy(string $id)
    {
        try {
            $this->profileService->deleteProfile($id);
            return response()->json(['message' => 'Le profil a bien été supprimé.'], Response::HTTP_OK);
        } catch (NotFoundHttpException $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Une erreur est survenue.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
