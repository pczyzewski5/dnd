<?php

declare(strict_types=1);

namespace App\User\Handler;

use App\Repository\UserRepository;
use App\User\Command\DeleteUser;
use App\User\UserPersister;

class DeleteUserHandler
{
    private UserRepository $userRepository;
    private UserPersister $userPersister;

    public function __construct(
        UserRepository $userRepository,
        UserPersister $userPersister
    ) {
        $this->userRepository = $userRepository;
        $this->userPersister = $userPersister;
    }

    public function handle(DeleteUser $command): void
    {
        $this->userPersister->delete(
            $this->userRepository->getOneById(
                $command->getUserId()
            )
        );
    }
}
