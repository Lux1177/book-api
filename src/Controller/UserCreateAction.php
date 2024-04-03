<?php

declare(strict_types=1);

namespace App\Controller;

use App\Components\User\UserFactory;
use App\Components\User\UserManager;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserCreateAction extends AbstractController
{
    public function __construct(private UserFactory $userFactory, private UserManager $userManager)
    {
    }

    public function __invoke(User $user): User
    {
        $newUser = $this->userFactory->create(
            $user->getEmail(),
            $user->getPassword(),
            $user->getAge(),
            $user->getGender(),
            $user->getPhone()
        );

        $this->userManager->save($newUser, true);

        return $newUser;
    }
}
