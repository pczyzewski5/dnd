<?php

declare(strict_types=1);

namespace DND\Infrastructure\User;

use DateTime;
use DND\Domain\User\User as DomainUser;
use DND\Domain\User\UserDTO;
use App\DateTimeNormalizer;

class UserMapper
{
    public static function toDomain(User $entity): DomainUser
    {
        $dto = new UserDTO();
        $dto->id = $entity->id;
        $dto->email = $entity->email;
        $dto->username = $entity->username;
        $dto->roles = \json_decode($entity->roles);
        $dto->password = $entity->password;
        $dto->isActive = $entity->isActive;
        $dto->createdAt = DateTimeNormalizer::normalizeToImmutable(
            $entity->createdAt
        );

        return new DomainUser($dto);
    }

    public static function fromDomain(
        DomainUser $domainEntity
    ): User {
        $entity = new User();
        $entity->id = $domainEntity->getId();
        $entity->email = $domainEntity->getEmail();
        $entity->username = $domainEntity->getUsername();
        $entity->roles = \json_encode($domainEntity->getRoles());
        $entity->password = $domainEntity->getPassword();
        $entity->isActive = $domainEntity->isActive();
        $entity->createdAt = DateTime::createFromImmutable(
            $domainEntity->getCreatedAt()
        );

        return $entity;
    }

    /**
     * @return DomainUser[]
     */
    public static function mapArrayToDomain(array $entities): array
    {
        return \array_map(
            static fn (User $entity) => self::toDomain($entity),
            $entities
        );
    }
}
