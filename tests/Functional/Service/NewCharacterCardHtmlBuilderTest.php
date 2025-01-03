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
        'race' => 'human variant',
        'alignment' => 'chaotic good',
        'levels' => [
            [
                'level' => 1,
                'class' => 'barbarian',
                'proficiencies' => [
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
                        'source' => 'character class'
                    ],
                    [
                        'name' => 'perception',
                        'source' => 'character class'
                    ],
                    [
                        'name' => 'stealth',
                        'source' => 'race'
                    ],
                ],
                'skills' => [
                    'BelQuath Song',
                ],
                'feat' => [
                    'name' => 'feat lucky',
                    'source' => 'race'
                ],
                'languages' => [
                    [
                        'name' => 'elf',
                        'source' => 'race'
                    ]
                ],
                'asi' => [
                    [
                        'ability' => 'str',
                        'value' => 1,
                        'source' => 'race'
                    ],
                    [
                        'ability' => 'con',
                        'value' => 1,
                        'source' => 'race'
                    ]
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
                    [
                        'ability' => 'con',
                        'value' => 2,
                        'source' => 'level'
                    ]
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
            [
                'level' => 7,
                'class' => 'berserker',
            ],
            [
                'level' => 8,
                'class' => 'berserker',
                'feat' => [
                    'name' => 'great weapon mastery',
                    'source' => 'level'
                ],
            ],
            [
                'level' => 9,
                'class' => 'berserker',
            ],
        ],
        'abilities' => [
            [
                'ability' => 'str',
                'value' => 15,
            ],
            [
                'ability' => 'dex',
                'value' => 14,
            ],
            [
                'ability' => 'con',
                'value' => 13,
            ],
            [
                'ability' => 'int',
                'value' =>  8,
            ],
            [
                'ability' => 'wis',
                'value' => 12,
            ],
            [
                'ability' => 'cha',
                'value' =>  10,
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
