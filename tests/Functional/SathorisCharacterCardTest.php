<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use DND\Character\Character;
use DND\Character\CharacterFactory;
use DND\Skill\Skills\BendLuck;
use DND\Skill\Skills\FeatSpellSniper;
use DND\Skill\Skills\FontOfMagic;
use DND\Skill\Skills\HellishResistance;
use DND\Skill\Skills\InfernalLegacy;
use DND\Skill\Skills\Metamagic;
use DND\Skill\Skills\MysticWisdom;
use DND\Skill\Skills\TidesOfChaos;
use DND\Skill\Skills\WildMagicSurge;
use PHPUnit\Framework\TestCase;
use DND\Domain\Enum\ProficiencyEnum;
use DND\Skill\Skills\Spellcasting;

class SathorisCharacterCardTest extends TestCase
{
    private Character $characterUnderTest;

    /**
     * @test
     * @covers
     */
    public function checkTitleData(): void
    {
        $this->assertSame('Sathoris', $this->characterUnderTest->getCharacterName());
        $this->assertSame('wild magic sorcerer', $this->characterUnderTest->getCharacterClass()->getName());
        $this->assertSame(9, $this->characterUnderTest->getActualLevel());
        $this->assertSame('szlachcic', $this->characterUnderTest->getOrigin());
        $this->assertSame('Wiktoria I', $this->characterUnderTest->getPlayerName());
        $this->assertSame('tiefling', $this->characterUnderTest->getRace()->getName());
        $this->assertSame('lawful evil', $this->characterUnderTest->getAlignment()->getValue());
        $this->assertSame('Klątwa Sthrada', $this->characterUnderTest->getCampaignName());
    }

    /**
     * @test
     * @covers
     */
    public function checkAbilities(): void
    {
        $abilities = $this->characterUnderTest->getAbilities();

        $this->assertSame(10, $abilities->getStr()->getValue());
        $this->assertSame(12, $abilities->getDex()->getValue());
        $this->assertSame(13, $abilities->getCon()->getValue());
        $this->assertSame(15, $abilities->getInt()->getValue());
        $this->assertSame(8, $abilities->getWis()->getValue());
        $this->assertSame(19, $abilities->getCha()->getValue());

        $this->assertSame(0, $abilities->getStr()->getModifier());
        $this->assertSame(1, $abilities->getDex()->getModifier());
        $this->assertSame(1, $abilities->getCon()->getModifier());
        $this->assertSame(2, $abilities->getInt()->getModifier());
        $this->assertSame(-1, $abilities->getWis()->getModifier());
        $this->assertSame(4, $abilities->getCha()->getModifier());
    }

    /**
     * @test
     * @covers
     */
    public function checkSavingThrowsProficiency(): void
    {
        $proficiencies = $this->characterUnderTest->getProficiencies()->getAll();

        $this->assertContains(ProficiencyEnum::CON, $proficiencies);
        $this->assertContains(ProficiencyEnum::CHA, $proficiencies);
    }

    /**
     * @test
     * @covers
     */
    public function checkAbilitySkillsProficiency(): void
    {
        $proficiencies = $this->characterUnderTest->getProficiencies()->getAll();

        $this->assertContains(ProficiencyEnum::HISTORY, $proficiencies);
        $this->assertContains(ProficiencyEnum::PERSUASION, $proficiencies);
        $this->assertContains(ProficiencyEnum::INVESTIGATION, $proficiencies);
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
        $this->assertContains(ProficiencyEnum::ROD, $proficiencies);
        $this->assertContains(ProficiencyEnum::LIGHT_CROSSBOW, $proficiencies);
        $this->assertContains(ProficiencyEnum::SLING, $proficiencies);
        $this->assertContains(ProficiencyEnum::DART, $proficiencies);
        $this->assertContains(ProficiencyEnum::DAGGER, $proficiencies);
        $this->assertContains(ProficiencyEnum::DICE_GAME, $proficiencies);
    }

    /**
     * @test
     * @covers
     */
    public function checkStats(): void
    {
        $this->assertSame(47, $this->characterUnderTest->getHitPoints());
        $this->assertSame(4, $this->characterUnderTest->getProficiencyBonus());
        $this->assertSame(11, $this->characterUnderTest->getArmorClassWithoutArmor());
        $this->assertSame(1, $this->characterUnderTest->getInitiative());
        $this->assertSame(12, $this->characterUnderTest->getNightvision());
        $this->assertSame(6, $this->characterUnderTest->getSpeed());
    }

    /**
     * @test
     * @covers
     */
    public function checkLanguages(): void
    {
        $this->assertSame(['common', 'infernal', 'undercommon'], $this->characterUnderTest->getLanguages());
    }

    /**
     * @test
     * @covers
     */
    public function checkHitDices(): void
    {
        $this->assertSame(['D6' => 9], $this->characterUnderTest->getHitDices());
    }

    /**
     * @test
     * @covers
     */
    public function checkActiveSkills(): void
    {
        $activeSkills = \array_map('get_class', $this->characterUnderTest->getActiveSkills());

        $this->assertContains(Spellcasting::class, $activeSkills);
        $this->assertContains(FontOfMagic::class, $activeSkills);
        $this->assertContains(Metamagic::class, $activeSkills);
        $this->assertContains(TidesOfChaos::class, $activeSkills);
        $this->assertContains(BendLuck::class, $activeSkills);
        $this->assertContains(FeatSpellSniper::class, $activeSkills);
        $this->assertContains(MysticWisdom::class, $activeSkills);
    }

    /**
     * @test
     * @covers
     */
    public function checkPassiveSkills(): void
    {
        $passiveSkills = \array_map('get_class', $this->characterUnderTest->getPassiveSkills());

        $this->assertContains(HellishResistance::class, $passiveSkills);
        $this->assertContains(InfernalLegacy::class, $passiveSkills);
        $this->assertContains(WildMagicSurge::class, $passiveSkills);
    }

    /**
     * @test
     * @covers
     */
    public function checkSpellData(): void
    {
        $this->assertSame(
            [
                'spellAttackMod' => 8,
                'spellDC' => 16,
                'spellCount' => 10
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
                ['circle' => 'III', 'count' => 3],
                ['circle' => 'IV', 'count' => 3],
                ['circle' => 'V', 'count' => 1],
            ],
            $this->characterUnderTest->getSpellCircles()
        );
    }

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $data = \file_get_contents(__DIR__ . '/data/sathoris.json');
        $data = \json_decode($data, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception('Invalid character data json.');
        }

        $this->characterUnderTest = CharacterFactory::createFromArray($data);
    }
}
