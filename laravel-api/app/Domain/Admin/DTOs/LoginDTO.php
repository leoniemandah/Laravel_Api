<?php

namespace App\Domain\Admin\DTOs;

class LoginDTO
{
    public function __construct(
        public string $email,
        public string $password,
    ) {}
}
