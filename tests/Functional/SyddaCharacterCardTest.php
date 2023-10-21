<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use DND\Character\Character;
use DND\Character\CharacterFactory;
use DND\Domain\Enum\ProficiencyEnum;
use DND\Skill\Skills\BonusAttack;
use DND\Skill\Skills\BrutalCritical;
use DND\Skill\Skills\DangerSense;
use DND\Skill\Skills\FastMovement;
use DND\Skill\Skills\FeralInstinct;
use DND\Skill\Skills\Frenzy;
use DND\Skill\Skills\MindlessRage;
use DND\Skill\Skills\Rage;
use DND\Skill\Skills\RecklessAttack;
use DND\Skill\Skills\UnarmoredDefense;
use PHPUnit\Framework\TestCase;

class SyddaCharacterCardTest extends TestCase
{
    private Character $characterUnderTest;

    /**
     * @test
     * @covers
     */
    public function checkTitleData(): void
    {
        $this->assertSame('Sydda', $this->characterUnderTest->getCharacterName());
        $this->assertSame('berserker', $this->characterUnderTest->getCharacterClass()->getName());
        $this->assertSame(9, $this->characterUnderTest->getActualLevel());
        $this->assertSame('ludowy bohater', $this->characterUnderTest->getOrigin());
        $this->assertSame('Bartek J', $this->characterUnderTest->getPlayerName());
        $this->assertSame('human', $this->characterUnderTest->getRace()->getName());
        $this->assertSame('chaotic good', $this->characterUnderTest->getAlignment()->getValue());
        $this->assertSame('Klątwa Sthrada', $this->characterUnderTest->getCampaignName());
    }

    /**
     * @test
     * @covers
     */
    public function checkAbilities(): void
    {
        $abilities = $this->characterUnderTest->getAbilities();

        $this->assertSame(16, $abilities->getStr()->getValue());
        $this->assertSame(14, $abilities->getDex()->getValue());
        $this->assertSame(16, $abilities->getCon()->getValue());
        $this->assertSame(8, $abilities->getInt()->getValue());
        $this->assertSame(12, $abilities->getWis()->getValue());
        $this->assertSame(10, $abilities->getCha()->getValue());

        $this->assertSame(3, $abilities->getStr()->getModifier());
        $this->assertSame(2, $abilities->getDex()->getModifier());
        $this->assertSame(3, $abilities->getCon()->getModifier());
        $this->assertSame(-1, $abilities->getInt()->getModifier());
        $this->assertSame(1, $abilities->getWis()->getModifier());
        $this->assertSame(0, $abilities->getCha()->getModifier());
    }

    /**
     * @test
     * @covers
     */
    public function checkSavingThrowsProficiency(): void
    {
        $proficiencies = $this->characterUnderTest->getProficiencies()->getAll();

        $this->assertContains(ProficiencyEnum::STR, $proficiencies);
        $this->assertContains(ProficiencyEnum::CON, $proficiencies);
    }

    /**
     * @test
     * @covers
     */
    public function checkAbilitySkillsProficiency(): void
    {
        $proficiencies = $this->characterUnderTest->getProficiencies()->getAll();

        $this->assertContains(ProficiencyEnum::ATHLETICS, $proficiencies);
        $this->assertContains(ProficiencyEnum::ANIMAL_HANDLING, $proficiencies);
        $this->assertContains(ProficiencyEnum::PERCEPTION, $proficiencies);
        $this->assertContains(ProficiencyEnum::STEALTH, $proficiencies);
        $this->assertContains(ProficiencyEnum::SURVIVAL, $proficiencies);
    }

    /**
     * @test
     * @covers
     */
    public function checkProficiencies(): void
    {
        $proficiencies = $this->characterUnderTest->getProficiencies()->getAll();

        $this->assertContains(ProficiencyEnum::LIGHT_ARMORS, $proficiencies);
        $this->assertContains(ProficiencyEnum::MEDIUM_ARMORS, $proficiencies);
        $this->assertContains(ProficiencyEnum::SHIELDS, $proficiencies);
        $this->assertContains(ProficiencyEnum::SIMPLE_WEAPONS, $proficiencies);
        $this->assertContains(ProficiencyEnum::MARTIAL_WEAPONS, $proficiencies);
        $this->assertContains(ProficiencyEnum::TINKER_TOOLS, $proficiencies);
        $this->assertContains(ProficiencyEnum::LAND_VEHICLES, $proficiencies);
    }

    /**
     * @test
     * @covers
     */
    public function checkStats(): void
    {
        $this->assertSame(95, $this->characterUnderTest->getHitPoints());
        $this->assertSame(4, $this->characterUnderTest->getProficiencyBonus());
        $this->assertSame(15, $this->characterUnderTest->getArmorClassWithoutArmor());
        $this->assertSame(2, $this->characterUnderTest->getInitiative());
        $this->assertSame(0, $this->characterUnderTest->getNightvision());
        $this->assertSame(8, $this->characterUnderTest->getSpeed());
    }

    /**
     * @test
     * @covers
     */
    public function checkLanguages(): void
    {
        $this->assertSame(['common', 'elf'], $this->characterUnderTest->getLanguages());
    }

    /**
     * @test
     * @covers
     */
    public function checkHitDices(): void
    {
        $this->assertSame(['D12' => 9], $this->characterUnderTest->getHitDices());
    }

    /**
     * @test
     * @covers
     */
    public function checkActiveSkills(): void
    {
        $activeSkills = \array_map('get_class', $this->characterUnderTest->getActiveSkills());

        $this->assertContains(Rage::class, $activeSkills);
        $this->assertContains(RecklessAttack::class, $activeSkills);
        $this->assertContains(BrutalCritical::class, $activeSkills);
        $this->assertContains(Frenzy::class, $activeSkills);
        $this->assertContains(MindlessRage::class, $activeSkills);
        $this->assertContains(DangerSense::class, $activeSkills);
        $this->assertContains(FeralInstinct::class, $activeSkills);
    }

    /**
     * @test
     * @covers
     */
    public function checkPassiveSkills(): void
    {
        $passiveSkills = \array_map('get_class', $this->characterUnderTest->getPassiveSkills());

        $this->assertContains(UnarmoredDefense::class, $passiveSkills);
        $this->assertContains(BonusAttack::class, $passiveSkills);
        $this->assertContains(FastMovement::class, $passiveSkills);
    }

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $data = \file_get_contents(__DIR__ . '/data/sydda.json');
        $data = \json_decode($data, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception('Invalid character data json.');
        }

        $this->characterUnderTest = CharacterFactory::createFromArray($data);
    }
}
