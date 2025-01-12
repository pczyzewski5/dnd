<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use InvalidArgumentException;

use function sprintf;

trait CollectionTrait
{
    protected function addToCollection(array $newItems, Collection $collection): void
    {
        foreach ($newItems as $newItem) {
            $this->validate($newItem, $collection);

            $collection->contains($newItem) ?: $collection->add($newItem);
        }

    }

    private function validate(object $newItem, Collection $collection): void
    {
        $firstItem = $collection->first();

        if (false === $firstItem || $firstItem::class === $newItem::class) {
            return;
        }

        throw new InvalidArgumentException(
            sprintf(
                'New item is instance of %s, it does not match first item instance of: %s.',
                $newItem::class,
                $firstItem::class
            )
        );
    }
}
