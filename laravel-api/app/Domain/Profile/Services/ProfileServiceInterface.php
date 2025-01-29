<?php

namespace App\Domain\Profile\Services;


use App\Domain\Profile\Dtos\ProfileDTO;
use App\Domain\Profile\Models\Profile;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

interface ProfileServiceInterface
{
    public function createProfile(ProfileDTO $profileDTO, UploadedFile $image): Profile;

    public function updateProfile(ProfileDTO $profileDTO, string $id, ?UploadedFile $image);

    public function getAllProfile(Request $request): LengthAwarePaginator;

    public function getProfileById(string $id) : Profile;

    public function deleteProfile(string $id);
}
