<?php

declare(strict_types=1);

namespace DND\Infrastructure\ItemCard;

use DateTime;
use DND\Domain\Enum\ItemCardCategoryEnum;
use DND\Domain\ItemCard\ItemCard as DomainItemCard;
use DND\Domain\ItemCard\ItemCardDTO;
use App\DateTimeNormalizer;

class ItemCardMapper
{
    public static function toDomain(ItemCard $entity): DomainItemCard
    {
        $dto = new ItemCardDTO();
        $dto->id = $entity->id;
        $dto->title = $entity->title;
        $dto->description = $entity->description;
        $dto->origin = $entity->origin;
        $dto->category = ItemCardCategoryEnum::from($entity->category);
        $dto->authorId = $entity->authorId;
        $dto->createdAt = DateTimeNormalizer::normalizeToImmutable(
            $entity->createdAt
        );

        return new DomainItemCard($dto);
    }

    public static function fromDomain(
        DomainItemCard $domainEntity
    ): ItemCard {
        $entity = new ItemCard();
        $entity->id = $domainEntity->getId();
        $entity->title = $domainEntity->getTitle();
        $entity->description = $domainEntity->getDescription();
        $entity->origin = $domainEntity->getOrigin();
        $entity->category = $domainEntity->getCategory()->getValue();
        $entity->authorId = $domainEntity->getAuthorId();
        $entity->createdAt = DateTime::createFromImmutable(
            $domainEntity->getCreatedAt()
        );

        return $entity;
    }

    /**
     * @return DomainItemCard[]
     */
    public static function mapArrayToDomain(array $entities): array
    {
        return \array_map(
            static fn (ItemCard $entity) => self::toDomain($entity),
            $entities
        );
    }
}
