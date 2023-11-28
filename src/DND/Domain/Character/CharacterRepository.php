<?php

declare(strict_types=1);

namespace DND\Domain\Character;

use DND\Domain\Character\Exception\CharacterNotFoundException;

interface CharacterRepository
{
    /**
     * @throws CharacterNotFoundException
     */
    public function getOneById(string $id): Character;

    /**
     * @return Character[]
     */
    public function findAll(): array;

    /**
     * @return Character[]
     */
    public function findByOwner(string $ownerId): array;
}
