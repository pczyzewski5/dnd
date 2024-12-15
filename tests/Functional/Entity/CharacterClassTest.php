<?php

declare(strict_types=1);

namespace App\Tests\Functional\Entity;

use App\Ability\NewAbilities;
use App\Ability\NewAbilityFactory;
use App\Builder\CharacterBuilder;
use App\Entity\CharacterClass;
use App\Entity\Level;
use App\Enum\NewAbilityEnum;
use App\Enum\NewCharacterClassEnum;
use App\Enum\NewHitDiceEnum;
use App\NewLevel\NewLevels;
use App\Repository\CharacterClassRepository;
use App\Repository\LevelRepository;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;
use PHPUnit\Framework\Attributes\Group;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

use function getenv;
use function var_dump;

class CharacterClassTest extends KernelTestCase
{
    use RefreshDatabaseTrait;

    private CharacterClassRepository $characterClassRepository;
    private EntityManagerInterface $entityManager;

    protected function setUp(): void
    {
        self::bootKernel();

        $container = self::getContainer();

        $this->characterClassRepository = $container->get(CharacterClassRepository::class);
        $this->entityManager = $container->get(EntityManagerInterface::class);
    }

    public function testUniqueName(): void
    {
        $characterClass = $this->characterClassRepository->find(1);

        $this->expectException(
            UniqueConstraintViolationException::class
        );
        $this->expectExceptionMessageMatches(
            '*Duplicate entry \'barbarian\' for key \'character_class.name\'*'
        );

        $this->entityManager->persist(
            new CharacterClass(
                $characterClass->getHitDice(),
                $characterClass->getName()
            )
        );
        $this->entityManager->flush();
    }
}
