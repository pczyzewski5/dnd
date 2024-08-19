<?php

declare(strict_types=1);

namespace DND\Domain\Query;

use App\User\User;
use App\User\UserRepository;

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
    public function __invoke(GetUsers $query): array
    {
        $allUsers = $this->userRepository->findAllUsers();
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
