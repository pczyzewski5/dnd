<?php

declare(strict_types=1);

namespace App\Tests\Functional\Mapper;

use App\Dto\AbilitiesDto;
use App\Dto\CharacterConfigDto;
use App\Dto\LevelDto;
use App\Mapper\CharacterConfigDtoMapper;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Group;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Exception\ValidationFailedException;

use function json_encode;

#[Group('dev')]
class CharacterConfigDtoMapperTest extends KernelTestCase
{
    private const CHARACTER_CONFIG = [
        'character_name' => 'Sydda',
        'player_name' => 'Bartek J',
        'campaign_name' => 'Klątwa Sthrada',
        'origin' => 'hero folk',
        'race' => 'human',
        'alignment' => 'chaotic good',
        'levels' => [
            [
                'level' => 1,
                'class' => 'barbarian',
                'proficiencies' => [
                    'survival',
                    'animal handling',
                ],
                'skills' => [
                    'Bel\'Quath Song',
                ],
            ],
            [
                'level' => 2,
                'class' => 'barbarian',
            ],
            [
                'level' => 3,
                'class' => 'berserker',
            ],
            [
                'level' => 4,
                'class' => 'berserker',
                'asi' => [
                    'con' => 2,
                ],
            ],
            [
                'level' => 5,
                'class' => 'berserker',
            ],
            [
                'level' => 6,
                'class' => 'berserker',
            ],
        ],
        'abilities' => [
            'str' => 15,
            'dex' => 13,
            'con' => 13,
            'int' => 7,
            'wis' => 11,
            'cha' => 9,
        ],
    ];

    private CharacterConfigDtoMapper $testedObject;

    protected function setUp(): void
    {
        self::bootKernel();

        $container = self::getContainer();

        $this->testedObject = $container->get(CharacterConfigDtoMapper::class);
    }

    #[DataProvider('keyProvider')]
    public function testBuildWhenMissingKey(string $key): void
    {
        $data = self::CHARACTER_CONFIG;
        unset($data[$key]);
        $data = json_encode($data);

        $this->expectException(ValidationFailedException::class);

        $this->testedObject->fromJson($data);
    }

    #[DataProvider('keyProvider')]
    public function testBuildWhenValueIsNull(string $key): void
    {
        $data = self::CHARACTER_CONFIG;
        $data[$key] = null;
        $data = json_encode($data);

        $this->expectException(ValidationFailedException::class);

        $this->testedObject->fromJson($data);
    }

    #[DataProvider('keyProvider')]
    public function testBuildWhenValueIsInvalidType(string $key): void
    {
        $data = self::CHARACTER_CONFIG;
        $data[$key] = 0.0;
        $data = json_encode($data);

        $this->expectException(ValidationFailedException::class);

        $this->testedObject->fromJson($data);
    }

    public static function keyProvider(): array
    {
        return [
            ['character_name'],
            ['player_name'],
            ['campaign_name'],
            ['origin'],
            ['race'],
            ['alignment'],
            ['levels'],
            ['abilities']
        ];
    }

    public function testBuild(): void
    {
        $levels = [
          new LevelDto(
              1,
              'barbarian',
              ['survival', 'animal handling'],
              ['Bel\'Quath Song'],
          ),
          new LevelDto(2, 'barbarian'),
          new LevelDto(3, 'berserker'),
          new LevelDto(4, 'berserker'),
          new LevelDto(5, 'berserker'),
          new LevelDto(6, 'berserker'),
        ];
        $abilitiesDto = new AbilitiesDto(
            15,
            13,
            13,
            7,
            11,
            9
        );
        $expected = new CharacterConfigDto(
            'Sydda',
            'Bartek J',
            'Klątwa Sthrada',
            'hero folk',
            'human',
            'chaotic good',
            $levels,
            $abilitiesDto,
        );

        $actual = $this->testedObject->fromJson(
            json_encode(self::CHARACTER_CONFIG)
        );

        $this->assertEquals($expected, $actual);
    }
}
