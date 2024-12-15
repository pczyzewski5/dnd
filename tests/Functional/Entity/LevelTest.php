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
use App\Repository\SkillRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;
use PHPUnit\Framework\Attributes\Group;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

use function getenv;
use function var_dump;

class LevelTest extends KernelTestCase
{
    use RefreshDatabaseTrait;

    private LevelRepository $levelRepository;
    private EntityManagerInterface $entityManager;

    protected function setUp(): void
    {
        self::bootKernel();

        $container = self::getContainer();

        $this->levelRepository = $container->get(LevelRepository::class);
        $this->entityManager = $container->get(EntityManagerInterface::class);
    }

    public function testUniqueLevelAndCharacter(): void
    {
        $level = $this->levelRepository->find(1);

        $this->expectException(
            UniqueConstraintViolationException::class
        );
        $this->expectExceptionMessageMatches(
            '*Duplicate entry \'1-1\' for key \'level.character_class_id\'*'
        );

        $this->entityManager->persist(
            new Level(
                $level->getLevel(),
                $level->getCharacterClass(),
            )
        );
        $this->entityManager->flush();
    }

    public function testUniqueSkill(): void
    {
        $level = $this->levelRepository->find(1);
        $skills = [
            $level->getSkills()->first(),
            $level->getSkills()->first(),
        ];
        $newLevel = new Level(
            1,
            $level->getCharacterClass(),
            $skills
        );

        $actual = $newLevel->getSkills()->count();

        $this->assertSame(1, $actual);
    }
}
