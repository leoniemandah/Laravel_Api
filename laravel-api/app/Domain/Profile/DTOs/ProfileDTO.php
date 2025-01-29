<?php


namespace App\Domain\Profile\DTOs;

class ProfileDTO
{
    public function __construct(
        public string $lastName,
        public string $firstName,
        public ?string $image,
        public string $status
    ) {}
}
