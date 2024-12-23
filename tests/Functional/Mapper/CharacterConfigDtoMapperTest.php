<?php

declare(strict_types=1);

namespace App\Tests\Functional\Mapper;

use App\Dto\AbilityConfigDto;
use App\Dto\CharacterConfigDto;
use App\Dto\LevelConfigDto;
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
        ],
        'abilities' => [
            [
                'ability' =>'str',
                'value' => 15,
            ],
            [
                'ability' =>'dex',
                'value' => 13,
            ],
            [
                'ability' =>'con',
                'value' => 13,
            ],
            [
                'ability' =>'int',
                'value' =>  7,
            ],
            [
                'ability' =>'wis',
                'value' => 11,
            ],
            [
                'ability' =>'cha',
                'value' =>  9,
            ],
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
    public function testFromJsonWhenMissingKey(string $key): void
    {
        $data = self::CHARACTER_CONFIG;
        unset($data[$key]);
        $data = json_encode($data);

        $this->expectException(ValidationFailedException::class);

        $this->testedObject->fromJson($data);
    }

    #[DataProvider('keyProvider')]
    public function testFromJsonWhenValueIsNull(string $key): void
    {
        $data = self::CHARACTER_CONFIG;
        $data[$key] = null;
        $data = json_encode($data);

        $this->expectException(ValidationFailedException::class);

        $this->testedObject->fromJson($data);
    }

    #[DataProvider('keyProvider')]
    public function testFromJsonWhenValueIsInvalidType(string $key): void
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

    public function testFromJson(): void
    {
        $levelConfigDtos = [
            new LevelConfigDto(
                1,
                'barbarian',
                ['survival', 'animal handling'],
                ['Bel\'Quath Song'],
            ),
            new LevelConfigDto(2, 'barbarian'),
            new LevelConfigDto(3, 'berserker'),
        ];
        $abilityConfigDtos = [
            new AbilityConfigDto('str', 15),
            new AbilityConfigDto('dex', 13),
            new AbilityConfigDto('con', 13),
            new AbilityConfigDto('int', 7),
            new AbilityConfigDto('wis', 11),
            new AbilityConfigDto('cha', 9),
        ];
        $expected = new CharacterConfigDto(
            'Sydda',
            'Bartek J',
            'Klątwa Sthrada',
            'hero folk',
            'human',
            'chaotic good',
            $levelConfigDtos,
            $abilityConfigDtos,
        );

        $actual = $this->testedObject->fromJson(
            json_encode(self::CHARACTER_CONFIG)
        );

        $this->assertEquals($expected, $actual);
    }
}
