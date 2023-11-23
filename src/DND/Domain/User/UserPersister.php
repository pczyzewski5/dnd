<?php

declare(strict_types=1);

namespace DND\Domain\User;

use DND\Domain\Exception\PersisterException;

interface UserPersister
{
    /**
     * @throws PersisterException
     */
    public function save(User $user): void;

    /**
     * @throws PersisterException
     */
    public function update(User $user): void;

    /**
     * @throws PersisterException
     */
    public function delete(User $user): void;
}
