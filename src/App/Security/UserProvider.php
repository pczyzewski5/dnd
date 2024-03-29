<?php

declare(strict_types=1);

namespace App\Security;

use DND\Domain\User\Exception\UserException;
use DND\Domain\User\User;
use DND\Domain\User\UserRepository;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserProvider implements UserProviderInterface
{
    private UserRepository $userRepository;

    public function __construct(
        UserRepository $userRepository
    ) {
        $this->userRepository = $userRepository;
    }

    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        $user = $this->userRepository->findUserByEmail($identifier);

        if (null === $user) {
            throw new UserNotFoundException();
        }
        if ($user->isActive() === false) {
            throw UserException::notActive();
        }

        return $user;
    }

    public function loadUserByUsername(string $username): UserInterface
    {
        $user = $this->userRepository->findUserByEmail($username);

        if (null === $user) {
            throw new UserNotFoundException();
        }

        return $user;
    }

    public function refreshUser(UserInterface $user): UserInterface
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(
                \sprintf('Invalid user class "%s".', \get_class($user))
            );
        }

        $user = $this->userRepository->findOneById($user->getId());

        if (null === $user) {
            throw new UserNotFoundException();
        }

        return $user;
    }

    public function supportsClass(string $class): bool
    {
        return User::class === $class || \is_subclass_of($class, User::class);
    }
}
