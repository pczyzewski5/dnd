<?php

declare(strict_types=1);

namespace App\User\Query;

use App\Repository\UserRepository;
use App\User\Entity\User;

class GetUsersHandler
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @return User[]
     */
    public function handle(GetUsers $query): array
    {
        $allUsers = $this->userRepository->findAll();
        if (null === $query->getExcludeUser()) {
            return $allUsers;
        }

        $result = [];

        foreach ($allUsers as $user) {
            if ($user->getId() === $query->getExcludeUser()->getId()) {
                continue;
            }

            $result[] = $user;
        }

        return $result;
    }
}
