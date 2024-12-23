<?php

declare(strict_types=1);

namespace App\Tests\Functional\Mapper;

use App\Dto\AbilityConfigDto;
use App\Dto\LevelConfigDto;
use App\Mapper\LevelConfigDtoMapper;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Group;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Exception\ValidationFailedException;

#[Group('dev')]
class LevelConfigDtoMapperTest extends KernelTestCase
{
    private const LEVEL_CONFIG = [
        'level' => 1,
        'class' => 'barbarian',
        'proficiencies' => [
            'survival',
            'animal handling',
        ],
        'skills' => [
            'Bel\'Quath Song',
        ],
        'asi' => [
            [
                'ability' => 'str',
                'value' => 10
            ],
            [
                'ability' => 'cha',
                'value' => 11
            ],
        ]
    ];

    private LevelConfigDtoMapper $testedObject;

    protected function setUp(): void
    {
        self::bootKernel();

        $container = self::getContainer();

        $this->testedObject = $container->get(LevelConfigDtoMapper::class);
    }

    #[DataProvider('requiredKeyProvider')]
    public function testFromArrayWhenMissingRequiredKey(
        string $key
    ): void {
        $data = self::LEVEL_CONFIG;
        unset($data[$key]);

        $this->expectException(ValidationFailedException::class);

        $this->testedObject->fromArray($data);
    }

    #[DataProvider('requiredKeyProvider')]
    public function testFromArrayWhenRequiredKeyIsNull(
        string $key
    ): void {
        $data = self::LEVEL_CONFIG;
        $data[$key] = null;

        $this->expectException(ValidationFailedException::class);

        $this->testedObject->fromArray($data);
    }

    public static function requiredKeyProvider(): array
    {
        return [
            ['level'],
            ['class'],
        ];
    }

    #[DataProvider('notRequiredKeyProvider')]
    public function testFromArrayWhenMissingNotRequiredKey(
        string $key,
    ): void {
        $data = self::LEVEL_CONFIG;
        unset($data[$key]);
        $expected = new LevelConfigDto(1, 'barbarian');

        $actual = $this->testedObject->fromArray($data);

        $this->assertSame($expected->class, $actual->class);
        $this->assertIsArray($actual->proficiencies);
        $this->assertIsArray($actual->skills);
    }

    #[DataProvider('notRequiredKeyProvider')]
    public function testFromArrayWhenNotRequiredKeyAreNull(
        string $key
    ): void {
        $data = self::LEVEL_CONFIG;
        $data[$key] = null;
        $expected = new LevelConfigDto(1, 'barbarian');

        $actual = $this->testedObject->fromArray($data);

        $this->assertSame($expected->class, $actual->class);
        $this->assertIsArray($actual->proficiencies);
        $this->assertIsArray($actual->skills);
    }

    public static function notRequiredKeyProvider(): array
    {
        return [
            ['proficiencies'],
            ['skills'],
            ['asi'],
        ];
    }

    public function testFromArray(): void
    {
        $expected = new LevelConfigDto(
            1,
            'barbarian',
            ['survival', 'animal handling'],
            ['Bel\'Quath Song'],
            [
                new AbilityConfigDto('str', 10),
                new AbilityConfigDto('cha', 11),
            ]
        );

        $actual = $this->testedObject->fromArray(self::LEVEL_CONFIG);

        $this->assertEquals($expected, $actual);
    }
}
