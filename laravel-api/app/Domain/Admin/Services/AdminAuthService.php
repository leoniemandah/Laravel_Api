<?php

namespace App\Domain\Admin\Services;

use App\Domain\Admin\Repositories\AdminRepositoryInterface;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Hash;

class AdminAuthService
{
    protected AdminRepositoryInterface $repository;

    public function __construct(AdminRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function authenticate(string $email, string $password): string
    {
        $admin = $this->repository->findByEmail($email);

        if (!$admin || !Hash::check($password, $admin->password)) {
            throw new AuthenticationException('Les identifiants sont incorrects.');
        }

        return $admin->createToken('admin-token')->plainTextToken;
    }
}

