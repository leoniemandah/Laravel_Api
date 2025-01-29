<?php

namespace App\Domain\Admin\Repositories;

use App\Domain\Admin\Models\Admin;

class AdminRepository
{
    public function findByEmail(string $email)
    {
        return Admin::where('email', $email)->first();
    }

    public function create(array $data)
    {
        return Admin::create($data);
    }

    public function update(Admin $admin, array $data)
    {
        $admin->update($data);
        return $admin;
    }

    public function delete(Admin $admin)
    {
        return $admin->delete();
    }
}
