<?php

declare(strict_types=1);

namespace App\Tests\Unit\Builder;

use App\Ability\AbilitiesConfig;
use App\Builder\CharacterConfigBuilder;
use App\Dto\AbilitiesConfigDto;
use App\Dto\CharacterConfigDto;
use App\Dto\LevelConfigDto;
use App\Level\LevelConfig;
use App\NewCharacter\CharacterConfig;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;

#[Group('dev')]
class CharacterConfigBuilderTest extends TestCase
{
    private CharacterConfigBuilder $testedObject;

    protected function setUp(): void
    {
        $this->testedObject = new CharacterConfigBuilder();
    }

    public function testBuild(): void
    {
        $levelConfigDto = new LevelConfigDto(
            1,
            'barbarian',
            ['light armors', 'medium armors'],
            ['animal handling', 'stealth']
        );
        $abilitiesConfigDto = new AbilitiesConfigDto(
            10,
            11,
            12,
            13,
            14,
            15
        );
        $dto = new CharacterConfigDto(
            'Sydda',
            'Bartek',
            'Klątwa Sthrada',
            'folk hero',
            'human',
            'chaotic good',
            [$levelConfigDto],
            $abilitiesConfigDto
        );
        $levelConfigs = [
            new LevelConfig(
                $levelConfigDto->level,
                $levelConfigDto->class,
                $levelConfigDto->skills,
                $levelConfigDto->proficiencies
            )
        ];
        $abilitiesConfig = new AbilitiesConfig(
            $abilitiesConfigDto->str,
            $abilitiesConfigDto->dex,
            $abilitiesConfigDto->con,
            $abilitiesConfigDto->int,
            $abilitiesConfigDto->wis,
            $abilitiesConfigDto->cha
        );
        $expected = new CharacterConfig(
            $dto->characterName,
            $dto->playerName,
            $dto->campaignName,
            $dto->alignment,
            $dto->race,
            $dto->origin,
            $levelConfigs,
            $abilitiesConfig
        );

        $actual = $this->testedObject->build($dto);

        $this->assertEquals($expected, $actual);
    }
}
