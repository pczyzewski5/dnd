<?php

declare(strict_types=1);

namespace App\Tests\Unit\Calculator;


use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use App\Calculator\AbilityModifierCalculator;

class AbilityModifierCalculatorTest extends TestCase
{
    #[DataProvider('calculateDataProvider')]
    public function testCalculate(int $abilityValue, int $expectedModifier): void
    {
        $actual = AbilityModifierCalculator::calculate($abilityValue);

        $this->assertSame($expectedModifier, $actual);
    }

    public static function calculateDataProvider(): array
    {
        return [
            ['ability value' => 1, 'expected modifier' => -5],
            ['ability value' => 2, 'expected modifier' => -4],
            ['ability value' => 3, 'expected modifier' => -4],
            ['ability value' => 4, 'expected modifier' => -3],
            ['ability value' => 5, 'expected modifier' => -3],
            ['ability value' => 6, 'expected modifier' => -2],
            ['ability value' => 7, 'expected modifier' => -2],
            ['ability value' => 8, 'expected modifier' => -1],
            ['ability value' => 9, 'expected modifier' => -1],
            ['ability value' => 10, 'expected modifier' => 0],
            ['ability value' => 11, 'expected modifier' => 0],
            ['ability value' => 12, 'expected modifier' => 1],
            ['ability value' => 13, 'expected modifier' => 1],
            ['ability value' => 14, 'expected modifier' => 2],
            ['ability value' => 15, 'expected modifier' => 2],
            ['ability value' => 16, 'expected modifier' => 3],
            ['ability value' => 17, 'expected modifier' => 3],
            ['ability value' => 18, 'expected modifier' => 4],
            ['ability value' => 19, 'expected modifier' => 4],
            ['ability value' => 20, 'expected modifier' => 5],
            ['ability value' => 21, 'expected modifier' => 5],
            ['ability value' => 22, 'expected modifier' => 6],
            ['ability value' => 23, 'expected modifier' => 6],
            ['ability value' => 24, 'expected modifier' => 7],
            ['ability value' => 25, 'expected modifier' => 7],
            ['ability value' => 26, 'expected modifier' => 8],
            ['ability value' => 27, 'expected modifier' => 8],
            ['ability value' => 28, 'expected modifier' => 9],
            ['ability value' => 29, 'expected modifier' => 9],
            ['ability value' => 30, 'expected modifier' => 10],
        ];
    }

    #[DataProvider('invalidAbilityValueProvider')]
    public function testCalculateWithInvalidAbilityValue(int $abilityValue): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Ability value must be between 1 and 30.');

        AbilityModifierCalculator::calculate($abilityValue);
    }

    public static function invalidAbilityValueProvider(): array
    {
        return [
            [0],
            [31],
        ];
    }
}
