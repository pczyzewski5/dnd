<?php

declare(strict_types=1);

namespace App\Tests\Functional\Entity;

use App\Entity\Level;
use App\Enum\NewCharacterClassEnum;
use App\Enum\NewHitDiceEnum;
use App\Repository\LevelRepository;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

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
