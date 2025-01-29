<?php

namespace App\Domain\Profile\Repositories;

use App\Domain\Profile\Dtos\ProfileDTO;
use App\Domain\Profile\Models\Profile;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

interface ProfileRepositoryInterface
{
    public function create(ProfileDTO $profileDTO, string $imageName): Profile;

    public function update(ProfileDTO $profileDTO, Profile $profile, ?string $imageName): Profile;

    public function findAll(Request $request): LengthAwarePaginator;

    public function findById(string $id): ?Profile;

    public function delete(Profile $profile): bool;
}
