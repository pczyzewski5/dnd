<?php

declare(strict_types=1);

namespace App\Tests\Functional\Builder;

use App\Ability\NewAbilities;
use App\Ability\NewAbilityFactory;
use App\Builder\CharacterBuilder;
use App\Dto\AbilitiesConfigDto;
use App\Dto\CharacterConfigDto;
use App\Dto\LevelConfigDto;
use App\Enum\NewAbilityEnum;
use App\Skill\FinalizedSkill;
use PHPUnit\Framework\Attributes\Group;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

#[Group('dev')]
class CharacterBuilderTest extends KernelTestCase
{
    private CharacterBuilder $testedObject;

    protected function setUp(): void
    {
        self::bootKernel();

        $container = self::getContainer();

        $this->testedObject = $container->get(CharacterBuilder::class);
    }

    public function testBuild(): void
    {
        $firstLevelConfig = new LevelConfigDto(
            1,
            'barbarian',
            ['light armors', 'medium armors'],
            ['animal handling', 'stealth']
        );
        $secondLevelConfig = new LevelConfigDto(
            2,
            'barbarian',
        );
        $thirdLevelConfig = new LevelConfigDto(
            3,
            'berserker',
        );
        $abilitiesConfigDto = new AbilitiesConfigDto(
            15,
            13,
            13,
            7,
            11,
            9
        );
        $configDto = new CharacterConfigDto(
            'Sydda',
            'Bartek',
            'Klątwa Sthrada',
            'folk hero',
            'human',
            'chaotic good',
            [$firstLevelConfig, $secondLevelConfig, $thirdLevelConfig],
            $abilitiesConfigDto
        );

        $actual = $this->testedObject->build($configDto);

        $this->assertSame('Sydda', $actual->characterName);
        $this->assertSame('Bartek', $actual->playerName);
        $this->assertSame('Klątwa Sthrada', $actual->campaignName);
        $this->assertSame([12 => 3], $actual->hitDices);
        $this->assertSame(29, $actual->hitPoints);
        $this->assertEquals(
            new NewAbilities(
                NewAbilityFactory::create(NewAbilityEnum::STR, 15),
                NewAbilityFactory::create(NewAbilityEnum::DEX, 13),
                NewAbilityFactory::create(NewAbilityEnum::CON, 13),
                NewAbilityFactory::create(NewAbilityEnum::INT, 7),
                NewAbilityFactory::create(NewAbilityEnum::WIS, 11),
                NewAbilityFactory::create(NewAbilityEnum::CHA, 9),
            ),
            $actual->abilities
        );
        $this->assertSame(['berserker' => 3], $actual->levels);
        $this->assertEquals(
            [
                new FinalizedSkill('rage', 'rage desc'),
                new FinalizedSkill('unarmored defense', 'jeśli nie nosisz zbroi, to twoja KP wynosi 12.')
            ],
            $actual->skills
        );
        $this->assertSame('folk hero', $actual->origin);
        $this->assertSame('human', $actual->race);
        $this->assertSame(['light armors', 'medium armors', 'shields'], $actual->armorProficiencies);
        $this->assertSame(['simple weapons', 'martial weapons'], $actual->weaponProficiencies);
        $this->assertSame([], $actual->toolProficiencies);
        $this->assertSame(['strength', 'constitution'], $actual->savingThrowProficiencies);
        $this->assertSame([], $actual->skillProficiencies);
    }
}
