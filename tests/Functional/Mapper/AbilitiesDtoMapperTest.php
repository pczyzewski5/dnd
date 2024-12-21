<?php

declare(strict_types=1);

namespace App\Tests\Functional\Mapper;

use App\Dto\AbilitiesDto;
use App\Mapper\AbilitiesDtoMapper;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Group;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Exception\ValidationFailedException;

use function array_keys;
use function file_get_contents;
use function json_decode;
use function json_encode;

#[Group('dev')]
class AbilitiesDtoMapperTest extends KernelTestCase
{
    private const DATA = [
        'str' => 10,
        'dex' => 11,
        'con' => 12,
        'wis' => 13,
        'int' => 14,
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
    public function testBuildWhenMissingKeys(string $key): void
    {
        $data = self::DATA;
        unset($data[$key]);

        $this->expectException(ValidationFailedException::class);

        $this->testedObject->fromArray($data);
    }

    #[DataProvider('keyProvider')]
    public function testBuildWhenValueIsNull(string $key): void
    {
        $data = self::DATA;
        $data[$key] = null;

        $this->expectException(ValidationFailedException::class);

        $this->testedObject->fromArray($data);
    }

    #[DataProvider('keyProvider')]
    public function testBuildWhenValueIsToSmall(string $key): void
    {
        $data = self::DATA;
        $data[$key] = 0;

        $this->expectException(ValidationFailedException::class);

        $this->testedObject->fromArray($data);
    }

    #[DataProvider('keyProvider')]
    public function testBuildWhenValueIsToBig(string $key): void
    {
        $data = self::DATA;
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
            ['wis'],
            ['int'],
            ['cha'],
        ];
    }

    public function testBuild(): void
    {
        $expected = new AbilitiesDto();
        $expected->str = 10;
        $expected->dex = 11;
        $expected->con = 12;
        $expected->wis = 13;
        $expected->int = 14;
        $expected->cha = 15;

        $actual = $this->testedObject->fromArray(self::DATA);

        $this->assertEquals($expected, $actual);
    }
}
