<?php

namespace App\Domain\Profile\Services;

use App\Domain\Profile\Repositories\ProfileRepository;
use App\Domain\Profile\Models\Profile;

class ProfileService
{
    protected $profileRepository;

    public function __construct(ProfileRepository $profileRepository)
    {
        $this->profileRepository = $profileRepository;
    }

    public function getAllProfiles()
    {
        return $this->profileRepository->getAll();
    }

    public function createProfile(array $data)
    {
        return $this->profileRepository->create($data);
    }

    public function updateProfile(Profile $profile, array $data)
    {
        return $this->profileRepository->update($profile, $data);
    }

    public function deleteProfile(Profile $profile)
    {
        return $this->profileRepository->delete($profile);
    }

    public function getActiveProfiles()
    {
        return $this->profileRepository->getActive();
    }
}
