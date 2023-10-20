<?php

declare(strict_types=1);

namespace Tests\Functional;

use DND\Character\Character;
use DND\Character\CharacterFactory;
use DND\Domain\Enum\ProficiencyEnum;
use DND\Skill\Skills\AcidBreath;
use DND\Skill\Skills\AcidResistance;
use DND\Skill\Skills\AuraOfProtection;
use DND\Skill\Skills\AuraOfWarding;
use DND\Skill\Skills\BonusAttack;
use DND\Skill\Skills\DivineHealth;
use DND\Skill\Skills\DivineSense;
use DND\Skill\Skills\DivineSmite;
use DND\Skill\Skills\FeatHeavyArmorMaster;
use DND\Skill\Skills\FeatSentinel;
use DND\Skill\Skills\FightingStyleProtection;
use DND\Skill\Skills\LayOnHands;
use DND\Skill\Skills\OathOfTheAncientsPaladinChannelDivinity;
use DND\Skill\Skills\OathOfTheAncientsPaladinSpells;
use DND\Skill\Skills\Spellcasting;
use PHPUnit\Framework\TestCase;

class MalrithCharacterCardTest extends TestCase
{
    private Character $characterUnderTest;

    /**
     * @test
     * @covers
     */
    public function checkTitleData(): void
    {
        $this->assertSame('Malrith', $this->characterUnderTest->getCharacterName());
        $this->assertSame('oath of the ancients paladin', $this->characterUnderTest->getCharacterClass()->getName());
        $this->assertSame(9, $this->characterUnderTest->getActualLevel());
        $this->assertSame('mroczna przeszłość', $this->characterUnderTest->getOrigin());
        $this->assertSame('Bartek N', $this->characterUnderTest->getPlayerName());
        $this->assertSame('copper dragonborn', $this->characterUnderTest->getRace()->getName());
        $this->assertSame('lawful good', $this->characterUnderTest->getAlignment()->getValue());
        $this->assertSame('Klątwa Sthrada', $this->characterUnderTest->getCampaignName());
    }

    /**
     * @test
     * @covers
     */
    public function checkAbilities(): void
    {
        $abilities = $this->characterUnderTest->getAbilities();

        $this->assertSame(17, $abilities->getStr()->getValue());
        $this->assertSame(8, $abilities->getDex()->getValue());
        $this->assertSame(13, $abilities->getCon()->getValue());
        $this->assertSame(10, $abilities->getInt()->getValue());
        $this->assertSame(12, $abilities->getWis()->getValue());
        $this->assertSame(16, $abilities->getCha()->getValue());

        $this->assertSame(3, $abilities->getStr()->getModifier());
        $this->assertSame(-1, $abilities->getDex()->getModifier());
        $this->assertSame(1, $abilities->getCon()->getModifier());
        $this->assertSame(0, $abilities->getInt()->getModifier());
        $this->assertSame(1, $abilities->getWis()->getModifier());
        $this->assertSame(3, $abilities->getCha()->getModifier());
    }

    /**
     * @test
     * @covers
     */
    public function checkSavingThrowsProficiency(): void
    {
        $proficiencies = $this->characterUnderTest->getProficiencies()->getAll();

        $this->assertContains(ProficiencyEnum::WIS, $proficiencies);
        $this->assertContains(ProficiencyEnum::CHA, $proficiencies);
    }

    /**
     * @test
     * @covers
     */
    public function checkAbilitySkillsProficiency(): void
    {
        $proficiencies = $this->characterUnderTest->getProficiencies()->getAll();

        $this->assertContains(ProficiencyEnum::INSIGHT, $proficiencies);
        $this->assertContains(ProficiencyEnum::PERSUASION, $proficiencies);
        $this->assertContains(ProficiencyEnum::SURVIVAL, $proficiencies);
        $this->assertContains(ProficiencyEnum::ARCANA, $proficiencies);
    }

    /**
     * @test
     * @covers
     */
    public function checkProficiencies(): void
    {
        $proficiencies = $this->characterUnderTest->getProficiencies()->getAll();

        // proficiencies
        $this->assertContains(ProficiencyEnum::LIGHT_ARMORS, $proficiencies);
        $this->assertContains(ProficiencyEnum::MEDIUM_ARMORS, $proficiencies);
        $this->assertContains(ProficiencyEnum::HEAVY_ARMORS, $proficiencies);
        $this->assertContains(ProficiencyEnum::SHIELDS, $proficiencies);
        $this->assertContains(ProficiencyEnum::SIMPLE_WEAPONS, $proficiencies);
        $this->assertContains(ProficiencyEnum::MARTIAL_WEAPONS, $proficiencies);
    }

    /**
     * @test
     * @covers
     */
    public function checkStats(): void
    {
        $this->assertSame(67, $this->characterUnderTest->getHitPoints());
        $this->assertSame(4, $this->characterUnderTest->getProficiencyBonus());
        $this->assertSame(9, $this->characterUnderTest->getArmorClassWithoutArmor());
        $this->assertSame(-1, $this->characterUnderTest->getInitiative());
        $this->assertSame(0, $this->characterUnderTest->getNightvision());
        $this->assertSame(6, $this->characterUnderTest->getSpeed());
    }

    /**
     * @test
     * @covers
     */
    public function checkLanguages(): void
    {
        $this->assertSame(['common', 'draconic', 'elf'], $this->characterUnderTest->getLanguages());
    }

    /**
     * @test
     * @covers
     */
    public function checkHitDices(): void
    {
        $this->assertSame(['D10' => 9], $this->characterUnderTest->getHitDices());
    }

    /**
     * @test
     * @covers
     */
    public function checkActiveSkills(): void
    {
        $activeSkills = \array_map('get_class', $this->characterUnderTest->getActiveSkills());

        $this->assertContains(AcidBreath::class, $activeSkills);
        $this->assertContains(DivineSense::class, $activeSkills);
        $this->assertContains(LayOnHands::class, $activeSkills);
        $this->assertContains(Spellcasting::class, $activeSkills);
        $this->assertContains(DivineSmite::class, $activeSkills);
        $this->assertContains(AuraOfProtection::class, $activeSkills);
        $this->assertContains(AuraOfWarding::class, $activeSkills);
        $this->assertContains(FeatHeavyArmorMaster::class, $activeSkills);
        $this->assertContains(FeatSentinel::class, $activeSkills);
        $this->assertContains(OathOfTheAncientsPaladinChannelDivinity::class, $activeSkills);
    }

    /**
     * @test
     * @covers
     */
    public function checkPassiveSkills(): void
    {
        $passiveSkills = \array_map('get_class', $this->characterUnderTest->getPassiveSkills());

        $this->assertContains(AcidResistance::class, $passiveSkills);
        $this->assertContains(FightingStyleProtection::class, $passiveSkills);
        $this->assertContains(DivineHealth::class, $passiveSkills);
        $this->assertContains(BonusAttack::class, $passiveSkills);
        $this->assertContains(OathOfTheAncientsPaladinSpells::class, $passiveSkills);
    }

    /**
     * @test
     * @covers
     */
    public function checkSpellData(): void
    {
        $this->assertSame(
            [
                'spellAttackMod' => 7,
                'spellDC' => 15,
                'spellCount' => 7
            ],
            $this->characterUnderTest->getSpellcastingData()
        );
    }

    /**
     * @test
     * @covers
     */
    public function checkSpellCircles(): void
    {
        $this->assertSame(
            [
                ['circle' => 'I', 'count' => 4],
                ['circle' => 'II', 'count' => 3],
                ['circle' => 'III', 'count' => 2]
            ],
            $this->characterUnderTest->getSpellCircles()
        );
    }

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $data = \file_get_contents(__DIR__ . '/data/malrith.json');
        $data = \json_decode($data, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception('Invalid character data json.');
        }

        $this->characterUnderTest = CharacterFactory::createFromArray($data);
    }
}
