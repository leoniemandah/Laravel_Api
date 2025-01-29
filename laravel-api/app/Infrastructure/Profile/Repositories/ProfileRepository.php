<?php

namespace App\Infrastructure\Profile\Repositories;

use App\Domain\Profile\Dtos\ProfileDTO;
use App\Domain\Profile\Models\Profile;
use App\Domain\Profile\Repositories\ProfileRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class ProfileRepository implements ProfileRepositoryInterface
{
    public function findAll(Request $request): LengthAwarePaginator
    {
        $query = Profile::query();

        $isAuth = auth('admin')->check();

        $limit = $request->input('limit', 10);

        // Si on n'est pas authentifié, on n'affiche que les profils actifs
        if (!$isAuth) {
            $query->where('status', 'actif');
        }

        // On ajoute un systeme de filtre sur le nom prénom et status
        if ($request->has('lastName')) {
            $query->where('lastName', 'like', '%' . $request->input('lastName') . '%');
        }
        if ($request->has('firstName')) {
            $query->where('firstName', 'like', '%' . $request->input('firstName') . '%');
        }
        if ($request->has('status') && $isAuth) {
            $query->where('status', '=',  $request->input('status'));
        }

        // On tri par la date de création
        $query->orderBy('created_at', 'desc');

        // Et enfin on pagine tout ça
        $profiles = $query->paginate($limit)
            ->appends($request->query());


        return $profiles;
    }

    public function create(ProfileDTO $profileDTO, string $imageName): Profile
    {
        return Profile::create([
            'lastName' => $profileDTO->lastName,
            'firstName' => $profileDTO->firstName,
            'image' => $imageName,
            'status' => $profileDTO->status,
        ]);
    }

    public function update(ProfileDTO $profileDTO, Profile $profile, ?string $imageName): Profile
    {

        $profile->lastName = $profileDTO->lastName;
        $profile->firstName = $profileDTO->firstName;
        $profile->status = $profileDTO->status;

        if ($imageName) {
            $profile->image = $imageName;
        }

        $profile->save();
        return $profile;
    }

    public function findById(string $id): ?Profile
    {
        $query = Profile::query();
        $isAuth = auth('admin')->check();

        if (!$isAuth) {
            // Si on n'est pas authentifié, on n'affiche que les profils actifs
            $query->where('status', 'actif');
        }

        $profile = $query->where('id', $id)->first();

        return $profile;
    }

    public function delete(Profile $profile): bool
    {
        return $profile->delete();
    }
}
