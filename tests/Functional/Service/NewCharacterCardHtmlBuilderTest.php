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
        'race' => 'human*',
        'alignment' => 'chaotic good',
        'levels' => [
            [
                'level' => 1,
                'class' => 'barbarian',
                'proficiencies' => [
                    [
                        'name' => 'survival',
                        'source' => 'origin'
                    ],
                    [
                        'name' => 'animal handling',
                        'source' => 'origin'
                    ],
                    [
                        'name' => 'land vehicles',
                        'source' => 'origin'
                    ],
                    [
                        'name' => 'tinker tools',
                        'source' => 'origin'
                    ],
                    [
                        'name' => 'athletics',
                        'source' => 'character_class'
                    ],
                    [
                        'name' => 'perception',
                        'source' => 'character_class'
                    ],
                    [
                        'name' => 'stealth',
                        'source' => 'race'
                    ],
                ],
                'skills' => [
                    'BelQuath Song',
                ],
            ],
            [
                'level' => 2,
                'class' => 'barbarian',
                'skills' => [
                    'reckless attack',
                    'danger sense',
                ],
            ],
            [
                'level' => 3,
                'class' => 'berserker',
                'skills' => [
                    'frenzy',
                ],
            ],
            [
                'level' => 4,
                'class' => 'berserker',
                'asi' => [
                    [
                        'ability' => 'con',
                        'value'=> 2
                    ]
                ],
            ],
            [
                'level' => 5,
                'class' => 'berserker',
                'skills' => [
                    'extra attack',
                    'fast movement'
                ],
            ],
            [
                'level' => 6,
                'class' => 'berserker',
                'skills' => [
                    'mindless rage'
                ],
            ],
            [
                'level' => 7,
                'class' => 'berserker',
                'skills' => [
                    'feral instinct'
                ],
            ],
            [
                'level' => 8,
                'class' => 'berserker',
                'skills' => [
                    'great weapon mastery'
                ],
            ],
            [
                'level' => 9,
                'class' => 'berserker',
                'skills' => [
                    'brutal critical'
                ],
            ],
        ],
        'abilities' => [
            [
                'ability' => 'str',
                'value' => 15,
            ],
            [
                'ability' => 'dex',
                'value' => 13,
            ],
            [
                'ability' => 'con',
                'value' => 13,
            ],
            [
                'ability' => 'int',
                'value' =>  7,
            ],
            [
                'ability' => 'wis',
                'value' => 11,
            ],
            [
                'ability' => 'cha',
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
