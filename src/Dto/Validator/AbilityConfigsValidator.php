<?php

namespace App\Dto\Validator;

use App\Dto\AbilityConfigDto;
use App\Enum\AbilityEnum;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class AbilityConfigsValidator extends ConstraintValidator
{
    private const ABILITY_SCORE_POINT_COST = [
        8 => 0,
        9 => 1,
        10 => 2,
        11 => 3,
        12 => 4,
        13 => 5,
        14 => 7,
        15 => 9,
    ];
    private const MAX_COST = 27;
    private const MAX_ABILITY_VALUE = 15;

    public function validate(mixed $value, Constraint $constraint): void
    {
        $this->validateType($value);
        $this->validateAbility($value);
        $this->validateValue($value);
        $this->validateScore($value);
    }

    private function validateType(mixed $value): void
    {
        if (is_array($value) === false) {
            $this->context->buildViolation('Abilities must be an array.')->addViolation();
        }
    }

    private function validateAbility(mixed $value): void
    {
        $actualAbilities = array_map(
            fn(AbilityConfigDto $dto): string => $dto->ability,
            $value
        );

        $missingAbilities = array_diff(
            AbilityEnum::values(),
            $actualAbilities,
        );

        foreach ($missingAbilities as $ability) {
            $this->context->buildViolation('Missing ability: {{ ability }}.')
                ->setParameter('{{ ability }}', $ability)
                ->addViolation();
        }
    }

    private function validateValue(mixed $value): void
    {
        foreach ($value as $dto) {
            if ($dto->value > 15) {
                $this->context->buildViolation('{{ ability }} value: {{ value }}, is invalid - max value is {{ maxAbilityValue }}.')
                    ->setParameter('{{ ability }}', ucfirst($dto->ability))
                    ->setParameter('{{ value }}', $dto->value)
                    ->setParameter('{{ maxAbilityValue }}', self::MAX_ABILITY_VALUE)
                    ->addViolation();
            }
        }
    }

    private function validateScore(mixed $value): void
    {
        $actualScore = 0;

        foreach ($value as $dto) {
            $actualScore += self::ABILITY_SCORE_POINT_COST[$dto->value] ?? 0;
        }

        if ($actualScore > self::MAX_COST) {
            $this->context->buildViolation("Actual ability score is: {{ actual }}, max is: {{ max }}.")
                ->setParameter('{{ actual }}', $actualScore)
                ->setParameter('{{ max }}', self::MAX_COST)
                ->addViolation();
        }
    }
}
