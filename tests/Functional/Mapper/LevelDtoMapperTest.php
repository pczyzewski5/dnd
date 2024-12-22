<?php

declare(strict_types=1);

namespace App\Tests\Functional\Mapper;

use App\Dto\LevelDto;
use App\Mapper\LevelDtoMapper;
use PHPUnit\Framework\Attributes\Group;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Exception\ValidationFailedException;

#[Group('dev')]
class LevelDtoMapperTest extends KernelTestCase
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
    ];

    private LevelDtoMapper $testedObject;

    protected function setUp(): void
    {
        self::bootKernel();

        $container = self::getContainer();

        $this->testedObject = $container->get(LevelDtoMapper::class);
    }

    public function testFromArrayWhenMissingRequiredKey(): void
    {
        $data = self::LEVEL_CONFIG;
        unset($data['class']);

        $this->expectException(ValidationFailedException::class);

        $this->testedObject->fromArray($data);
    }

    public function testFromArrayWhenRequiredKeyIsNull(): void
    {
        $data = self::LEVEL_CONFIG;
        $data['class'] = null;

        $this->expectException(ValidationFailedException::class);

        $this->testedObject->fromArray($data);
    }

    public function testFromArrayWhenMissingNotRequiredKey(): void
    {
        $data = self::LEVEL_CONFIG;
        unset($data['proficiencies']);
        unset($data['skills']);
        $expected = new LevelDto(1, 'barbarian');

        $actual = $this->testedObject->fromArray($data);

        $this->assertEquals($expected, $actual);
    }

    public function testFromArrayWhenNotRequiredKeyAreNull(): void
    {
        $data = self::LEVEL_CONFIG;
        $data['proficiencies'] = null;
        $data['skills'] = null;
        $expected = new LevelDto(1, 'barbarian');

        $actual = $this->testedObject->fromArray($data);

        $this->assertEquals($expected->class, $actual->class);
        $this->assertIsArray($actual->proficiencies);
        $this->assertIsArray($actual->skills);
    }
}
