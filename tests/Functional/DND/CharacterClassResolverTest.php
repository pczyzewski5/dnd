<?php

declare(strict_types=1);

namespace Tests\Functional\DND;

use DND\Character\LevelsFactory;
use DND\CharacterClass\CharacterClassResolver;
use PHPUnit\Framework\TestCase;

/**
 * @group dev
 */
class CharacterClassResolverTest extends TestCase
{
    /**
     * @test
     * @covers
     */
    public function underDev(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Only one subclass is supported.');

        $levels = LevelsFactory::fromArray([
            1 => ["class" => "rouge"],
            3 => ["class" => "druid"],
            2 => ["class" => "barbarian"]
        ]);
        CharacterClassResolver::getCharacterSubclass($levels);
    }

    /**
     * @test
     * @covers
     *
     * @dataProvider levelsProvider()
     */
    public function isShouldReturnProperCharacterClasses(
        array $levels,
        string $expectedCharacterClassName,
        ?string $expectedCharacterSubclassName
    ): void {
        $levels = LevelsFactory::fromArray($levels);

        $characterClass = CharacterClassResolver::getCharacterClass($levels);
        $characterSubclass = CharacterClassResolver::getCharacterSubclass($levels);

        $this->assertSame($expectedCharacterClassName, $characterClass->getValue());
        null === $expectedCharacterSubclassName
            ? $this->assertNull($characterSubclass)
            : $this->assertSame($expectedCharacterSubclassName, $characterSubclass->getValue());
    }

    public function levelsProvider(): array
    {
        return [
            'I' => [
                'levels' => [
                    1 => ["class" => "rouge"],
                    2 => ["class" => "rouge"],
                ],
                'expected character class name' => 'rouge',
                'expected character subclass name' => null
            ],
            'II' => [
                [
                    1 => ["class" => "rouge"],
                    2 => ["class" => "rouge"],
                    3 => ["class" => "barbarian"],
                    4 => ["class" => "barbarian"],
                ],
                'expected character class name' => 'rouge',
                'expected character subclass name' => 'barbarian'
            ],
            'III' => [
                [
                    1 => ["class" => "barbarian"],
                    2 => ["class" => "rouge"],
                    3 => ["class" => "barbarian"],
                    4 => ["class" => "barbarian"],
                ],
                'expected character class name' => 'barbarian',
                'expected character subclass name' => 'rouge'
            ],
            'IV' => [
                [
                    1 => ["class" => "rouge"],
                    2 => ["class" => "rouge"],
                    3 => ["class" => "assassin"],
                    4 => ["class" => "barbarian"],
                    5 => ["class" => "barbarian"],
                ],
                'expected character class name' => 'assassin',
                'expected character subclass name' => 'barbarian'
            ],
            'V' => [
                [
                    1 => ["class" => "rouge"],
                    2 => ["class" => "rouge"],
                    3 => ["class" => "assassin"],
                    4 => ["class" => "barbarian"],
                    5 => ["class" => "barbarian"],
                    6 => ["class" => "berserker"],
                ],
                'expected character class name' => 'assassin',
                'expected character subclass name' => 'berserker'
            ],
            'VI' => [
                [
                    1 => ["class" => "barbarian"],
                    2 => ["class" => "barbarian"],
                    3 => ["class" => "rouge"],
                    4 => ["class" => "rouge"],
                    5 => ["class" => "assassin"],
                    6 => ["class" => "berserker"],
                ],
                'expected character class name' => 'berserker',
                'expected character subclass name' => 'assassin'
            ],
        ];
    }
}
