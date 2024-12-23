<?php

declare(strict_types=1);

namespace App\Tests\Functional\Mapper;

use App\Dto\AbilityConfigDto;
use App\Mapper\AbilityConfigDtoMapper;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Group;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Exception\ValidationFailedException;

#[Group('dev')]
class AbilityConfigDtoMapperTest extends KernelTestCase
{
    private const ABILITY_CONFIG = [
        'ability' => 'str',
        'value' => 11,
    ];

    private AbilityConfigDtoMapper $testedObject;

    protected function setUp(): void
    {
        self::bootKernel();

        $container = self::getContainer();

        $this->testedObject = $container->get(AbilityConfigDtoMapper::class);
    }

    #[DataProvider('keyProvider')]
    public function testFromArrayWhenMissingKey(string $key): void
    {
        $data = self::ABILITY_CONFIG;
        unset($data[$key]);

        $this->expectException(ValidationFailedException::class);

        $this->testedObject->fromArray($data);
    }

    #[DataProvider('keyProvider')]
    public function testFromArrayWhenValueIsNull(string $key): void
    {
        $data = self::ABILITY_CONFIG;
        $data[$key] = null;

        $this->expectException(ValidationFailedException::class);

        $this->testedObject->fromArray($data);
    }

    public function testFromArrayWhenAbilityIsInvalid(): void
    {
        $data = self::ABILITY_CONFIG;
        $data['ability'] = 'invalid';

        $this->expectException(ValidationFailedException::class);

        $this->testedObject->fromArray($data);
    }

    public function testFromArrayWhenValueIsToSmall(): void
    {
        $data = self::ABILITY_CONFIG;
        $data['value'] = 0;

        $this->expectException(ValidationFailedException::class);

        $this->testedObject->fromArray($data);
    }

    public function testFromArrayWhenValueIsToBig(): void
    {
        $data = self::ABILITY_CONFIG;
        $data['value'] = 21;

        $this->expectException(ValidationFailedException::class);

        $this->testedObject->fromArray($data);
    }

    public static function keyProvider(): array
    {
        return [
            ['ability'],
            ['value'],
        ];
    }

    public function testFromArray(): void
    {
        $expected = new AbilityConfigDto(
            'str',
            11,
        );

        $actual = $this->testedObject->fromArray(self::ABILITY_CONFIG);

        $this->assertEquals($expected, $actual);
    }
}
