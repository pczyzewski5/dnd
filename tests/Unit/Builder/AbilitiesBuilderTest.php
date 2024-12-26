<?php

declare(strict_types=1);

namespace App\Tests\Unit\Builder;


use App\Ability\Abilities;
use App\Ability\AbilityFactory;
use App\Builder\AbilitiesBuilder;
use App\Dto\AbilityConfigDto;
use App\Enum\NewAbilityEnum;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use Exception;

class AbilitiesBuilderTest extends TestCase
{
    private AbilitiesBuilder $testedObject;

    protected function setUp(): void
    {
        $this->testedObject = new AbilitiesBuilder();
    }


    #[DataProvider('validAbilityConfigProvider')]
    public function testBuild(
        array $configs,
        Abilities $expected
    ): void {
        $this->testedObject->add(...$configs);

        $actual = $this->testedObject->build();

        $this->assertEquals($expected, $actual);
    }

    public static function validAbilityConfigProvider(): array
    {
        return [
            'happy path' => [
                'configs' => [
                    new AbilityConfigDto('str', 10),
                    new AbilityConfigDto('dex', 10),
                    new AbilityConfigDto('con', 10),
                    new AbilityConfigDto('int', 10),
                    new AbilityConfigDto('wis', 10),
                    new AbilityConfigDto('cha', 10)
                ],
                'expected' => new Abilities(
                    AbilityFactory::create(NewAbilityEnum::STR, 10),
                    AbilityFactory::create(NewAbilityEnum::DEX, 10),
                    AbilityFactory::create(NewAbilityEnum::CON, 10),
                    AbilityFactory::create(NewAbilityEnum::INT, 10),
                    AbilityFactory::create(NewAbilityEnum::WIS, 10),
                    AbilityFactory::create(NewAbilityEnum::CHA, 10),
                )
            ],
            'doubled configs' => [
                'configs' => [
                    new AbilityConfigDto('str', 10),
                    new AbilityConfigDto('str', 1),
                    new AbilityConfigDto('dex', 10),
                    new AbilityConfigDto('dex', 2),
                    new AbilityConfigDto('con', 10),
                    new AbilityConfigDto('con', 3),
                    new AbilityConfigDto('int', 10),
                    new AbilityConfigDto('int', 4),
                    new AbilityConfigDto('wis', 10),
                    new AbilityConfigDto('wis', 5),
                    new AbilityConfigDto('cha', 10),
                    new AbilityConfigDto('cha', 6),
                ],
                'expected' => new Abilities(
                    AbilityFactory::create(NewAbilityEnum::STR, 11),
                    AbilityFactory::create(NewAbilityEnum::DEX, 12),
                    AbilityFactory::create(NewAbilityEnum::CON, 13),
                    AbilityFactory::create(NewAbilityEnum::INT, 14),
                    AbilityFactory::create(NewAbilityEnum::WIS, 15),
                    AbilityFactory::create(NewAbilityEnum::CHA, 16),
                )
            ]
        ];
    }

    #[DataProvider('invalidAbilityConfigProvider')]
    public function testBuildWithInvalidData(array $configs): void {
        $this->testedObject->add(...$configs);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Ability value must be between 1 and 30.');

        $this->testedObject->build();
    }

    public static function invalidAbilityConfigProvider(): array
    {
        return [
            'no configs' => [
                []
            ],
            'too big strength value' => [
                [
                    new AbilityConfigDto('str', 40),
                    new AbilityConfigDto('dex', 10),
                    new AbilityConfigDto('con', 10),
                    new AbilityConfigDto('int', 10),
                    new AbilityConfigDto('wis', 10),
                    new AbilityConfigDto('cha', 10),
                    new AbilityConfigDto('cha', 10),
                ]
            ],
            'too big charisma sum' => [
                [new AbilityConfigDto('str', 10),
                    new AbilityConfigDto('dex', 10),
                    new AbilityConfigDto('con', 10),
                    new AbilityConfigDto('int', 10),
                    new AbilityConfigDto('wis', 10),
                    new AbilityConfigDto('cha', 10),
                    new AbilityConfigDto('cha', 25),]
            ],
        ];
    }
}
