<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use DND\Character\Character;
use DND\Character\CharacterFactory;
use DND\Domain\Enum\ProficiencyEnum;
use DND\Skill\Skills\AcidBreath;
use DND\Skill\Skills\AcidResistance;
use DND\Skill\Skills\Assassination;
use DND\Skill\Skills\AssassinProficiencies;
use DND\Skill\Skills\AuraOfProtection;
use DND\Skill\Skills\AuraOfWarding;
use DND\Skill\Skills\BonusAttack;
use DND\Skill\Skills\Brave;
use DND\Skill\Skills\CunningAction;
use DND\Skill\Skills\DivineHealth;
use DND\Skill\Skills\DivineSense;
use DND\Skill\Skills\DivineSmite;
use DND\Skill\Skills\Evasion;
use DND\Skill\Skills\Expertise;
use DND\Skill\Skills\FavoredEnemy;
use DND\Skill\Skills\FeatHeavyArmorMaster;
use DND\Skill\Skills\FeatSentinel;
use DND\Skill\Skills\FightingStyleProtection;
use DND\Skill\Skills\LayOnHands;
use DND\Skill\Skills\Lucky;
use DND\Skill\Skills\NaturalExplorer;
use DND\Skill\Skills\NaturallyStealthy;
use DND\Skill\Skills\Nimble;
use DND\Skill\Skills\OathOfTheAncientsPaladinChannelDivinity;
use DND\Skill\Skills\OathOfTheAncientsPaladinSpells;
use DND\Skill\Skills\SneakAttack;
use DND\Skill\Skills\Spellcasting;
use DND\Skill\Skills\ThievesCant;
use DND\Skill\Skills\UncannyDodge;
use PHPUnit\Framework\TestCase;

/**
 * @group dev
 */
class MordimerCharacterCardTest extends TestCase
{
    private Character $characterUnderTest;

    /**
     * @test
     * @covers
     */
    public function checkTitleData(): void
    {
        $this->assertSame('Mordimer Madderdin', $this->characterUnderTest->getCharacterName());
        $this->assertSame('assassin', $this->characterUnderTest->getCharacterClass()->getName());
        $this->assertSame(9, $this->characterUnderTest->getActualLevel());
        $this->assertSame('akolita', $this->characterUnderTest->getOrigin());
        $this->assertSame('Paweł', $this->characterUnderTest->getPlayerName());
        $this->assertSame('lightfoot halfling', $this->characterUnderTest->getRace()->getName());
        $this->assertSame('neutral evil', $this->characterUnderTest->getAlignment()->getValue());
        $this->assertSame('Klątwa Sthrada', $this->characterUnderTest->getCampaignName());
    }

    /**
     * @test
     * @covers
     */
    public function checkAbilities(): void
    {
        $abilities = $this->characterUnderTest->getAbilities();

        $this->assertSame(9, $abilities->getStr()->getValue());
        $this->assertSame(18, $abilities->getDex()->getValue());
        $this->assertSame(13, $abilities->getCon()->getValue());
        $this->assertSame(11, $abilities->getInt()->getValue());
        $this->assertSame(13, $abilities->getWis()->getValue());
        $this->assertSame(16, $abilities->getCha()->getValue());

        $this->assertSame(-1, $abilities->getStr()->getModifier());
        $this->assertSame(4, $abilities->getDex()->getModifier());
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

        $this->assertContains(ProficiencyEnum::DEX, $proficiencies);
        $this->assertContains(ProficiencyEnum::INT, $proficiencies);
    }

    /**
     * @test
     * @covers
     */
    public function checkAbilitySkillsProficiency(): void
    {
        $proficiencies = $this->characterUnderTest->getProficiencies()->getAll();

        $this->assertContains(ProficiencyEnum::ACROBATICS, $proficiencies);
        $this->assertContains(ProficiencyEnum::DECEPTION, $proficiencies);
        $this->assertContains(ProficiencyEnum::PERCEPTION, $proficiencies);
        $this->assertContains(ProficiencyEnum::PERSUASION, $proficiencies);
        $this->assertContains(ProficiencyEnum::STEALTH, $proficiencies);
        $this->assertContains(ProficiencyEnum::PERFORMANCE, $proficiencies);
        $this->assertContains(ProficiencyEnum::INVESTIGATION, $proficiencies);
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
        $this->assertContains(ProficiencyEnum::SIMPLE_WEAPONS, $proficiencies);
        $this->assertContains(ProficiencyEnum::HAND_CROSSBOW, $proficiencies);
        $this->assertContains(ProficiencyEnum::LONG_SWORD, $proficiencies);
        $this->assertContains(ProficiencyEnum::SHORT_SWORD, $proficiencies);
        $this->assertContains(ProficiencyEnum::RAPIER, $proficiencies);
        $this->assertContains(ProficiencyEnum::MAKEUP_KIT, $proficiencies);
        $this->assertContains(ProficiencyEnum::POISONER_KIT, $proficiencies);
        $this->assertContains(ProficiencyEnum::MEDIUM_ARMORS, $proficiencies);
        $this->assertContains(ProficiencyEnum::SHIELDS, $proficiencies);
        $this->assertContains(ProficiencyEnum::MARTIAL_WEAPONS, $proficiencies);
    }

    /**
     * @test
     * @covers
     */
    public function checkStats(): void
    {
        $this->assertSame(58, $this->characterUnderTest->getHitPoints());
        $this->assertSame(4, $this->characterUnderTest->getProficiencyBonus());
        $this->assertSame(14, $this->characterUnderTest->getArmorClassWithoutArmor());
        $this->assertSame(9, $this->characterUnderTest->getInitiative());
        $this->assertSame(0, $this->characterUnderTest->getNightvision());
        $this->assertSame(5, $this->characterUnderTest->getSpeed());
    }

    /**
     * @test
     * @covers
     */
    public function checkLanguages(): void
    {
        $this->assertSame(['common', 'halfling'], $this->characterUnderTest->getLanguages());
    }

    /**
     * @test
     * @covers
     */
    public function checkHitDices(): void
    {
        $this->assertSame(['D8' => 8, 'D10' => 1], $this->characterUnderTest->getHitDices());
    }

    /**
     * @test
     * @covers
     */
    public function checkActiveSkills(): void
    {
        $activeSkills = \array_map('get_class', $this->characterUnderTest->getActiveSkills());

        $this->assertContains(Lucky::class, $activeSkills);
        $this->assertContains(Brave::class, $activeSkills);
        $this->assertContains(SneakAttack::class, $activeSkills);
        $this->assertContains(CunningAction::class, $activeSkills);
        $this->assertContains(UncannyDodge::class, $activeSkills);
        $this->assertContains(Evasion::class, $activeSkills);
        $this->assertContains(Assassination::class, $activeSkills);
    }

    /**
     * @test
     * @covers
     */
    public function checkPassiveSkills(): void
    {
        $passiveSkills = \array_map('get_class', $this->characterUnderTest->getPassiveSkills());

        $this->assertContains(Nimble::class, $passiveSkills);
        $this->assertContains(NaturallyStealthy::class, $passiveSkills);
        $this->assertContains(Expertise::class, $passiveSkills);
        $this->assertContains(ThievesCant::class, $passiveSkills);
        $this->assertContains(AssassinProficiencies::class, $passiveSkills);
        $this->assertContains(FavoredEnemy::class, $passiveSkills);
        $this->assertContains(NaturalExplorer::class, $passiveSkills);
    }

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $data = \file_get_contents(__DIR__ . '/data/mordimer.json');
        $data = \json_decode($data, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception('Invalid character data json.');
        }

        $this->characterUnderTest = CharacterFactory::createFromArray($data);
    }
}
