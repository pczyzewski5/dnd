<?php

declare(strict_types=1);

namespace DND\Domain\Command;

use DND\Domain\Exception\PersisterException;
use DND\Domain\User\Exception\UserAlreadyExistsException;
use DND\Domain\User\UserDTO;
use DND\Domain\User\UserFactory;
use DND\Domain\User\UserPersister;
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

        $dto = new UserDTO();
        $dto->password = $hashedPassword;

        $user->update($dto);

        try {
            $this->userPersister->save($user);
        } catch (PersisterException $e) {
            throw new UserAlreadyExistsException();
        }
    }
}
