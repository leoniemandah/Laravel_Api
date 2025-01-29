<?php

namespace App\Domain\Profile\Repositories;

use App\Domain\Profile\Models\Profile;

class ProfileRepository
{
    public function getAll()
    {
        return Profile::all();
    }

    public function create(array $data)
    {
        return Profile::create($data);
    }

    public function update(Profile $profile, array $data)
    {
        $profile->update($data);
        return $profile;
    }

    public function delete(Profile $profile)
    {
        return $profile->delete();
    }

    public function getActive()
    {
        return Profile::where('statut', 'actif')->get();
    }
}
