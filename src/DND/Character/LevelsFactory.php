<?php

namespace DND\Character;

use DND\CharacterClass\CharacterClassFactory;

class LevelsFactory
{
    public static function fromArray(array $levels): Levels
    {
        $result = new Levels();

        foreach ($levels as $level => $data) {
            $result->addLevel(
                new Level(
                    $level,
                    CharacterClassFactory::createFromString($data['class'])
                )
            );
        }

        return $result;
    }
}