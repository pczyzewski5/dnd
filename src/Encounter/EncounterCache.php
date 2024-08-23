<?php

declare(strict_types=1);

namespace App\Encounter;

use App\Exception\CacheException;
use Psr\Cache\CacheItemPoolInterface;

class EncounterCache
{
    private const ENCOUNTER_KEY = 'encounter';
    private const EXPIRATION_TIME = 86400; // 24h

    public function __construct(private readonly CacheItemPoolInterface $pool)
    {
    }

    public function encounterExist(): bool
    {
        $item = $this->pool->getItem(self::ENCOUNTER_KEY);

        return $item->isHit();
    }

    public function getEncounter(): Encounter
    {
        $item = $this->pool->getItem(self::ENCOUNTER_KEY);

        if (false === $item->isHit()) {
            throw CacheException::keyNotFound(self::ENCOUNTER_KEY);
        }

        return $item->get();
    }

    public function saveEncounter(Encounter $encounter): void
    {
        $item = $this->pool->getItem(self::ENCOUNTER_KEY);
        $item->set($encounter);
        $item->expiresAfter(self::EXPIRATION_TIME);

        $this->pool->save($item);
    }

    public function deleteEncounter(): void
    {
        $this->pool->clear();
    }
}
