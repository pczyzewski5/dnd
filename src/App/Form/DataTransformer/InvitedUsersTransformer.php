<?php

declare(strict_types=1);

namespace App\Form\DataTransformer;

use DND\Domain\User\User;
use DND\Domain\User\UserRepository;
use Symfony\Component\Form\DataTransformerInterface;

class InvitedUsersTransformer implements DataTransformerInterface
{
    private UserRepository $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function transform(mixed $value): array
    {
        $result = [];

        /** @var User $user */
        foreach ($value as $user) {
            $result[] = [
                'value' => $user->getId(),
                'description' => $user->getUsername()
            ];
        }

        return $result;
    }

    /**
     * @return User[]
     */
    public function reverseTransform(mixed $value): array
    {
        $userIds = \array_filter($value);

        return empty($userIds)
            ? []
            : $this->repository->getManyById($userIds);
    }
}

