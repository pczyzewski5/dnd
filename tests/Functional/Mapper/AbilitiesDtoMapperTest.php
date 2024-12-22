<?php

declare(strict_types=1);

namespace App\Tests\Functional\Mapper;

use App\Dto\AbilitiesDto;
use App\Mapper\AbilitiesDtoMapper;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Group;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Exception\ValidationFailedException;

#[Group('dev')]
class AbilitiesDtoMapperTest extends KernelTestCase
{
    private const ABILITIES_CONFIG = [
        'str' => 10,
        'dex' => 11,
        'con' => 12,
        'int' => 13,
        'wis' => 14,
        'cha' => 15,
    ];

    private AbilitiesDtoMapper $testedObject;

    protected function setUp(): void
    {
        self::bootKernel();

        $container = self::getContainer();

        $this->testedObject = $container->get(AbilitiesDtoMapper::class);
    }

    #[DataProvider('keyProvider')]
    public function testFromArrayWhenMissingKey(string $key): void
    {
        $data = self::ABILITIES_CONFIG;
        unset($data[$key]);

        $this->expectException(ValidationFailedException::class);

        $this->testedObject->fromArray($data);
    }

    #[DataProvider('keyProvider')]
    public function testFromArrayWhenValueIsNull(string $key): void
    {
        $data = self::ABILITIES_CONFIG;
        $data[$key] = null;

        $this->expectException(ValidationFailedException::class);

        $this->testedObject->fromArray($data);
    }

    #[DataProvider('keyProvider')]
    public function testFromArrayWhenValueIsToSmall(string $key): void
    {
        $data = self::ABILITIES_CONFIG;
        $data[$key] = 0;

        $this->expectException(ValidationFailedException::class);

        $this->testedObject->fromArray($data);
    }

    #[DataProvider('keyProvider')]
    public function testFromArrayWhenValueIsToBig(string $key): void
    {
        $data = self::ABILITIES_CONFIG;
        $data[$key] = 21;

        $this->expectException(ValidationFailedException::class);

        $this->testedObject->fromArray($data);
    }

    public static function keyProvider(): array
    {
        return [
            ['str'],
            ['dex'],
            ['con'],
            ['int'],
            ['wis'],
            ['cha'],
        ];
    }

    public function testFromArray(): void
    {
        $expected = new AbilitiesDto(
            10,
            11,
            12,
            13,
            14,
            15,
        );

        $actual = $this->testedObject->fromArray(self::ABILITIES_CONFIG);

        $this->assertEquals($expected, $actual);
    }
}
