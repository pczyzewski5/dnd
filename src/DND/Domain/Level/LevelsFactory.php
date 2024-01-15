<?php

declare(strict_types=1);

namespace DND\Domain\Level;

use DND\Domain\Enum\CharacterClassEnum;

class LevelsFactory
{
    public static function fromArray(array $levels): Levels
    {
        $result = new Levels();

        foreach ($levels as $level => $data) {
            if (false === CharacterClassEnum::isValid($data['class'])) {
                // @todo change me
                throw new \Exception('Cannot level, invalid class: ' . $data['class']);
            }

            $result->addLevel(
                new Level(CharacterClassEnum::from($data['class']), $level)
            );
        }

        return $result;
    }
}