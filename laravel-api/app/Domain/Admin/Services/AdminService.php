<?php

namespace App\Domain\Admin\Services;

use App\Domain\Admin\Repositories\AdminRepository;
use App\Domain\Admin\Models\Admin;

class AdminService
{
    protected $adminRepository;

    public function __construct(AdminRepository $adminRepository)
    {
        $this->adminRepository = $adminRepository;
    }

    public function findAdminByEmail(string $email)
    {
        return $this->adminRepository->findByEmail($email);
    }

    public function createAdmin(array $data)
    {
        return $this->adminRepository->create($data);
    }

    public function updateAdmin(Admin $admin, array $data)
    {
        return $this->adminRepository->update($admin, $data);
    }

    public function deleteAdmin(Admin $admin)
    {
        return $this->adminRepository->delete($admin);
    }
}
