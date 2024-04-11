<?php

declare(strict_types=1);

namespace App\Components\User;

use Symfony\Component\Serializer\Attribute\Groups;

class UserFullNameDto
{
    public function __construct(
        #[Groups(['user:write', 'user:read'])]
        private string $givenName,

        #[Groups(['user:write', 'user:read'])]
        private string $familyName,

        #[Groups(['user:write', 'user:read'])]
        private bool $isMarried
    )
    {
    }

    public function getGivenName(): string
    {
        return $this->givenName;
    }

    public function getFamilyName(): string
    {
        return $this->familyName;
    }

    public function isMarried(): bool
    {
        return $this->isMarried;
    }
}
