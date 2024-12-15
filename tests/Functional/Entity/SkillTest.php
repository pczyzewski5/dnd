<?php

declare(strict_types=1);

namespace App\Tests\Functional\Entity;

use App\Ability\NewAbilities;
use App\Ability\NewAbilityFactory;
use App\Builder\CharacterBuilder;
use App\Entity\CharacterClass;
use App\Entity\Level;
use App\Entity\Skill;
use App\Enum\NewAbilityEnum;
use App\Enum\NewCharacterClassEnum;
use App\Enum\NewHitDiceEnum;
use App\NewLevel\NewLevels;
use App\Repository\CharacterClassRepository;
use App\Repository\LevelRepository;
use App\Repository\SkillRepository;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;
use PHPUnit\Framework\Attributes\Group;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

use function getenv;
use function var_dump;

class SkillTest extends KernelTestCase
{
    use RefreshDatabaseTrait;

    private SkillRepository $skillRepository;
    private EntityManagerInterface $entityManager;

    protected function setUp(): void
    {
        self::bootKernel();

        $container = self::getContainer();

        $this->skillRepository = $container->get(SkillRepository::class);
        $this->entityManager = $container->get(EntityManagerInterface::class);
    }

    public function testUniqueName(): void
    {
        $skill = $this->skillRepository->find(1);

        $this->expectException(
            UniqueConstraintViolationException::class
        );
        $this->expectExceptionMessageMatches(
            '*Duplicate entry \'rage\' for key \'skill.name\'*'
        );

        $this->entityManager->persist(
            new Skill(
                $skill->getName(),
                $skill->getDescription()
            )
        );
        $this->entityManager->flush();
    }
}
