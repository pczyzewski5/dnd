<?php

declare(strict_types=1);

namespace App\Tests\Functional\Service;

use App\Builder\CharacterBuilder;
use App\Mapper\CharacterConfigDtoMapper;
use App\Service\CharacterCardService;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;
use PHPUnit\Framework\Attributes\Group;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

use function file_put_contents;
use function json_encode;

#[Group('dev')]
class NewCharacterCardHtmlBuilderTest extends KernelTestCase
{
    private const CONFIG = [
        'character_name' => 'Sydda',
        'player_name' => 'Bartek J',
        'campaign_name' => 'Klątwa Sthrada',
        'origin' => 'folk hero',
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
        ]
    ];

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

    public function testBuild(): void
    {
        $html = $this->testedObject->getFrontpage(
            $this->characterBuilder->build(
                $this->characterConfigDtoMapper->fromJson(
                    json_encode(self::CONFIG, JSON_PRETTY_PRINT)
                )
            )
        );

        file_put_contents('output.html', $html);
    }
}
