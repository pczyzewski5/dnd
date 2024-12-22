<?php

namespace App\Calculator;

use App\Entity\Level;

class LevelsCalculator
{
    public function calculate(array $levels): array
    {
        $result = [];

        /** @var Level $level */
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