<?php

declare(strict_types=1);

namespace App\Tests\Functional\Builder;

use App\Ability\NewAbilities;
use App\Ability\NewAbilityFactory;
use App\Builder\CharacterBuilder;
use App\Dto\AbilityConfigDto;
use App\Dto\CharacterConfigDto;
use App\Dto\LevelConfigDto;
use App\Enum\NewAbilityEnum;
use App\Skill\FinalizedSkill;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;
use PHPUnit\Framework\Attributes\Group;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CharacterBuilderTest extends KernelTestCase
{
    use RefreshDatabaseTrait;

    private CharacterBuilder $testedObject;

    protected function setUp(): void
    {
        self::bootKernel();

        $container = self::getContainer();

        $this->testedObject = $container->get(CharacterBuilder::class);
    }

    public function testBuild(): void
    {
        $levelConfigDtos = [
            new LevelConfigDto(
                1,
                'barbarian',
                ['animal handling', 'stealth']
            ),
            new LevelConfigDto(
                2,
                'barbarian',
            ),
            new LevelConfigDto(
                3,
                'berserker',
            )
        ];
        $abilityConfigDtos = [
            new AbilityConfigDto('str', 15),
            new AbilityConfigDto('dex', 13),
            new AbilityConfigDto('con', 13),
            new AbilityConfigDto('int', 7),
            new AbilityConfigDto('wis', 11),
            new AbilityConfigDto('cha', 9)
        ];
        $configDto = new CharacterConfigDto(
            'Sydda',
            'Bartek',
            'Klątwa Sthrada',
            'folk hero',
            'human',
            'chaotic good',
            $levelConfigDtos,
            $abilityConfigDtos
        );

        $actual = $this->testedObject->build($configDto);

        $this->assertSame('Sydda', $actual->characterName);
        $this->assertSame('Bartek', $actual->playerName);
        $this->assertSame('Klątwa Sthrada', $actual->campaignName);
        $this->assertSame([12 => 3], $actual->hitDices);
        $this->assertSame(32, $actual->hitPoints);
        $this->assertEquals(
            new NewAbilities(
                NewAbilityFactory::create(NewAbilityEnum::STR, 16),
                NewAbilityFactory::create(NewAbilityEnum::DEX, 14),
                NewAbilityFactory::create(NewAbilityEnum::CON, 14),
                NewAbilityFactory::create(NewAbilityEnum::INT, 8),
                NewAbilityFactory::create(NewAbilityEnum::WIS, 12),
                NewAbilityFactory::create(NewAbilityEnum::CHA, 10),
            ),
            $actual->abilities
        );
        $this->assertSame(['berserker' => 3], $actual->simpleLevels);
        $this->assertEquals(
            [
                new FinalizedSkill('rage', 'rage desc'),
                new FinalizedSkill('unarmored defense', 'jeśli nie nosisz zbroi, to twoja KP wynosi 14.')
            ],
            $actual->skills
        );
        $this->assertSame('folk hero', $actual->origin);
        $this->assertSame('human', $actual->race);
        $this->assertSame(['light armors', 'medium armors', 'shields'], $actual->armorProficiencies);
        $this->assertSame(['simple weapons', 'martial weapons'], $actual->weaponProficiencies);
        $this->assertSame([], $actual->toolProficiencies);
        $this->assertSame(['strength', 'constitution'], $actual->savingThrowProficiencies);
    }
}
