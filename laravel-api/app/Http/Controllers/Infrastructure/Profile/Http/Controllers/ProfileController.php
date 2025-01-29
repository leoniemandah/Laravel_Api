<?php

namespace App\Http\Controllers\Infrastructure\Profile\Http\Controllers;

use App\Domain\Profile\Services\ProfileService;
use App\Infrastructure\Profile\Http\Requests\ProfileRequest;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    private ProfileService $profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    public function index(): JsonResponse
    {
        $profiles = $this->profileService->getAllProfiles();
        return response()->json($profiles, 200);
    }

    public function store(ProfileRequest $request): JsonResponse
    {
        $profile = $this->profileService->createProfile($request->validated());
        return response()->json($profile, 201);
    }

    public function update(ProfileRequest $request, int $id): JsonResponse
    {
        $updatedProfile = $this->profileService->updateProfile($id, $request->validated());
        return response()->json($updatedProfile, 200);
    }

    public function destroy(int $id): JsonResponse
    {
        $this->profileService->deleteProfile($id);
        return response()->json(null, 204);
    }
}
