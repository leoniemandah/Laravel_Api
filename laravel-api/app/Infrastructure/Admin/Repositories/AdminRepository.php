<?php

namespace App\Infrastructure\Admin\Repositories;

use App\Domain\Admin\Models\Admin;
use App\Domain\Admin\Repositories\AdminRepositoryInterface;

class AdminRepository implements AdminRepositoryInterface
{
    public function findByEmail(string $email): ?Admin
    {
        return Admin::where('email', $email)->first();
    }
}
