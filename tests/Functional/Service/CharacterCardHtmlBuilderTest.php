<?php

declare(strict_types=1);

namespace App\Tests\Functional\Service;

use App\Builder\CharacterBuilder;
use App\Mapper\CharacterConfigDtoMapper;
use App\Service\CharacterCardService;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Group;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

use function file_put_contents;

#[Group('dev')]
class CharacterCardHtmlBuilderTest extends KernelTestCase
{
    use RefreshDatabaseTrait;

    private CharacterConfigDtoMapper $characterConfigDtoMapper;
    private CharacterBuilder $characterBuilder;
    private CharacterCardService $testedObject;

    protected function setUp(): void
    {
        self::bootKernel();

        $container = self::getContainer();

        $this->characterConfigDtoMapper = $container->get(CharacterConfigDtoMapper::class);
        $this->characterBuilder = $container->get(CharacterBuilder::class);
        $this->testedObject = $container->get(CharacterCardService::class);
    }

    #[DataProvider('characterConfigProvider')]
    public function testBuild(string $json): void
    {
        $html = $this->testedObject->getFrontpage(
            $this->characterBuilder->build(
                $this->characterConfigDtoMapper->fromJson($json)
            )
        );

        file_put_contents('output.html', $html);
    }

    public static function characterConfigProvider(): array
    {
        $getConfig = fn (string $configFile): string
        => file_get_contents(__DIR__ . '/../../Data/' . $configFile);

        return [
            'Sydda' => [$getConfig('character_config_sydda.json')],
            'Mordimer' => [$getConfig('character_config_sydda.json')],
        ];
    }
}
