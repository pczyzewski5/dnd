<?php

namespace DND\Domain\Character;

use DND\Domain\Exception\PersisterException;

interface CharacterPersister
{
    /**
     * @throws PersisterException
     */
    public function save(Character $character): void;

    /**
     * @throws PersisterException
     */
    public function update(Character $character): void;

    /**
     * @throws PersisterException
     */
    public function delete(string $id): void;
}
