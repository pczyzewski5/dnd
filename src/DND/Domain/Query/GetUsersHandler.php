<?php

declare(strict_types=1);

namespace DND\Domain\Query;

use DND\Domain\User\User;
use DND\Domain\User\UserRepository;

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
        return $this->userRepository->findAllUsers();
    }
}
