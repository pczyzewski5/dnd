<?php

namespace App\Calculator;

use App\Collection\Levels;

// do read
class LevelsCalculator
{
    public function calculate(Levels $levels): array
    {
        $result = [];

        foreach ($levels as $level) {
            $className = $level->getCharacterClass()->getName();
            $baseClassName = $level->getCharacterClass()->getBaseClass()?->getName();

            \array_key_exists($className, $result)
                ?  $result[$className] += 1
                :  $result[$className] = 1;

            // cannibalize base classes
            if (\array_key_exists($baseClassName, $result)) {
                $result[$className] += $result[$baseClassName];

                unset($result[$baseClassName]);
            }
        }

        return $result;
    }
}