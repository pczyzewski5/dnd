<?php

declare(strict_types=1);

namespace DND\Domain;

trait MergerTrait
{
    private function merge($dto)
    {
        $properties = \array_keys(
            \get_class_vars(self::class)
        );

        foreach ($properties as $property) {
            if (isset($dto->$property)) {
                $this->$property = $dto->$property;
            }
        }
    }
}
