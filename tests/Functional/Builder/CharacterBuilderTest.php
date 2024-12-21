<?php

declare(strict_types=1);

namespace App\Tests\Functional\Builder;

use App\Ability\Abilities;
use App\Ability\NewAbilities;
use App\Ability\NewAbility;
use App\Ability\NewAbilityFactory;
use App\Builder\CharacterBuilder;
use App\Enum\NewAbilityEnum;
use App\Mapper\CharacterConfigMapper;
use App\Repository\LevelRepository;
use App\Skill\FinalizedSkill;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;
use PHPUnit\Framework\Attributes\Group;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

use function json_decode;
use function var_dump;

#[Group('dev')]
class CharacterBuilderTest extends KernelTestCase
{
    use RefreshDatabaseTrait;

    private CharacterConfigMapper $characterConfigMapper;
    private LevelRepository $levelRepository;
    private CharacterBuilder $testedObject;

    protected function setUp(): void
    {
        self::bootKernel();

        $container = self::getContainer();

        $this->characterConfigMapper = $container->get(CharacterConfigMapper::class);
        $this->levelRepository = $container->get(LevelRepository::class);
        $this->testedObject = $container->get(CharacterBuilder::class);
    }

    public function testBuild(): void
    {
        $characterConfig = $this->characterConfigMapper->mapFromJson(
            file_get_contents(__DIR__ . '/../../Data/sydda_config.json'),
        );

        $actual = $this->testedObject->build($characterConfig);

        $this->assertSame('Sydda', $actual->characterName);
        $this->assertSame('Bartek J', $actual->playerName);
        $this->assertSame('Klątwa Sthrada', $actual->campaignName);
        $this->assertSame([12 => 6], $actual->hitDices);
        $this->assertSame(53, $actual->hitPoints);
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
        $this->assertSame(['berserker' => 6], $actual->levels);
        $this->assertEquals(
            [
                new FinalizedSkill('rage', 'rage desc'),
                new FinalizedSkill('unarmored defense', 'jeśli nie nosisz zbroi, to twoja KP wynosi 12.')
            ],
            $actual->skills
        );
        $this->assertSame('hero folk', $actual->origin);
        $this->assertSame('human', $actual->race);
        $this->assertSame(['light armors', 'medium armors', 'shields'], $actual->armorProficiencies);
        $this->assertSame(['simple weapons', 'martial weapons'], $actual->weaponProficiencies);
        $this->assertSame([], $actual->toolProficiencies);
        $this->assertSame(['strength', 'constitution'], $actual->savingThrowProficiencies);
        $this->assertSame([], $actual->skillProficiencies);
    }
}
