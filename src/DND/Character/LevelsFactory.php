<?php

namespace DND\Character;

use DND\Domain\Enum\CharacterClassEnum;

class LevelsFactory
{
    public static function fromArray(array $levels): Levels
    {
        $result = new Levels();
        foreach ($levels as $level => $data) {
            $result->addLevel(
                new Level(
                    $level,
                    CharacterClassEnum::from($data['class'])
                )
            );
        }

        return $result;
    }
}