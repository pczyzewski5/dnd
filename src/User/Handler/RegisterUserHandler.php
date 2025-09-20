<?php

declare(strict_types=1);

namespace App\User\Handler;

use App\Exception\PersisterException;
use App\Exception\UserAlreadyExistsException;
use App\User\Command\RegisterUser;
use App\User\Entity\UserFactory;
use App\User\UserPersister;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegisterUserHandler
{
    private UserPasswordHasherInterface $userPasswordHasher;
    private UserPersister $userPersister;

    public function __construct(
        UserPasswordHasherInterface $userPasswordHasher,
        UserPersister $userPersister
    ) {
        $this->userPasswordHasher = $userPasswordHasher;
        $this->userPersister = $userPersister;
    }

    public function handle(RegisterUser $command): void
    {
        $user = UserFactory::create(
            $command->getEmail(),
            $command->getUsername(),
            [$command->getRole()],
            $command->getPassword(),
            $command->isActive()
        );

        $hashedPassword = $this->userPasswordHasher->hashPassword(
            $user,
            $command->getPassword()
        );

        $user->setPassword($hashedPassword);

        try {
            $this->userPersister->save($user);
        } catch (PersisterException $e) {
            throw new UserAlreadyExistsException();
        }
    }
}
