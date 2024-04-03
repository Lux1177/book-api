<?php

declare(strict_types=1);

namespace App\Components\User;

use App\Entity\User;
use DateTimeImmutable;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFactory
{
    public function __construct(private UserPasswordHasherInterface $userPasswordHasher)
    {
    }

    public function create(string $email, string $password, int $age, string $gender, string $phone): User
    {
        $user = new User();

        $hashedPassword = $this->userPasswordHasher->hashPassword($user, $password);

        $user->setEmail($email);
        $user->setPassword($hashedPassword);
        $user->setAge($age);
        $user->setGender($gender);
        $user->setPhone($phone);
        $user->setCreatedAt(new DateTimeImmutable());

        return $user;
    }
}
