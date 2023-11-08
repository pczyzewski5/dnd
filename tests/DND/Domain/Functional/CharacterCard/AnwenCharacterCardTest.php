<?php

declare(strict_types=1);

namespace App\Tests\DND\Domain\Functional\CharacterCard;

use DND\Domain\Character\Character;
use DND\Domain\Character\CharacterFactory;
use DND\Domain\Enum\ProficiencyEnum;
use DND\Domain\Skill\Skills\BonusLanguage;
use DND\Domain\Skill\Skills\Cantrip;
use DND\Domain\Skill\Skills\CircleForms;
use DND\Domain\Skill\Skills\CombatWildShape;
use DND\Domain\Skill\Skills\Druidic;
use DND\Domain\Skill\Skills\ElfWeaponTraining;
use DND\Domain\Skill\Skills\FeatWarCaster;
use DND\Domain\Skill\Skills\FeyAncestry;
use DND\Domain\Skill\Skills\KeenSenses;
use DND\Domain\Skill\Skills\PrimalStrike;
use DND\Domain\Skill\Skills\Spellcasting;
use DND\Domain\Skill\Skills\Trance;
use DND\Domain\Skill\Skills\WildShape;
use PHPUnit\Framework\TestCase;

class AnwenCharacterCardTest extends TestCase
{
    private Character $characterUnderTest;

    /**
     * @test
     * @covers
     */
    public function checkTitleData(): void
    {
        $this->assertSame('Anwen', $this->characterUnderTest->getCharacterName());
        $this->assertSame('circle of moon druid', $this->characterUnderTest->getCharacterClass()->getName());
        $this->assertSame(9, $this->characterUnderTest->getActualLevel());
        $this->assertSame('mędrzec', $this->characterUnderTest->getOrigin());
        $this->assertSame('Kasia', $this->characterUnderTest->getPlayerName());
        $this->assertSame('high elf', $this->characterUnderTest->getRace()->getName());
        $this->assertSame('neutral good', $this->characterUnderTest->getAlignment()->getValue());
        $this->assertSame('Klątwa Sthrada', $this->characterUnderTest->getCampaignName());
    }

    /**
     * @test
     * @covers
     */
    public function checkAbilities(): void
    {
        $abilities = $this->characterUnderTest->getAbilities();

        $this->assertSame(8, $abilities->getStr()->getValue());
        $this->assertSame(14, $abilities->getDex()->getValue());
        $this->assertSame(14, $abilities->getCon()->getValue());
        $this->assertSame(14, $abilities->getInt()->getValue());
        $this->assertSame(17, $abilities->getWis()->getValue());
        $this->assertSame(10, $abilities->getCha()->getValue());

        $this->assertSame(-1, $abilities->getStr()->getModifier());
        $this->assertSame(2, $abilities->getDex()->getModifier());
        $this->assertSame(2, $abilities->getCon()->getModifier());
        $this->assertSame(2, $abilities->getInt()->getModifier());
        $this->assertSame(3, $abilities->getWis()->getModifier());
        $this->assertSame(0, $abilities->getCha()->getModifier());
    }

    /**
     * @test
     * @covers
     */
    public function checkSavingThrowsProficiency(): void
    {
        $proficiencies = $this->characterUnderTest->getProficiencies()->getAll();

        $this->assertContains(ProficiencyEnum::WIS, $proficiencies);
        $this->assertContains(ProficiencyEnum::INT, $proficiencies);
    }

    /**
     * @test
     * @covers
     */
    public function checkAbilitySkillsProficiency(): void
    {
        $proficiencies = $this->characterUnderTest->getProficiencies()->getAll();

        $this->assertContains(ProficiencyEnum::HISTORY, $proficiencies);
        $this->assertContains(ProficiencyEnum::PERCEPTION, $proficiencies);
        $this->assertContains(ProficiencyEnum::NATURE, $proficiencies);
        $this->assertContains(ProficiencyEnum::RELIGION, $proficiencies);
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
        $this->assertContains(ProficiencyEnum::SHIELDS, $proficiencies);
        $this->assertContains(ProficiencyEnum::MACE, $proficiencies);
        $this->assertContains(ProficiencyEnum::ROD, $proficiencies);
        $this->assertContains(ProficiencyEnum::JAVELIN, $proficiencies);
        $this->assertContains(ProficiencyEnum::CLUB, $proficiencies);
        $this->assertContains(ProficiencyEnum::SLING, $proficiencies);
        $this->assertContains(ProficiencyEnum::SCIMITAR, $proficiencies);
        $this->assertContains(ProficiencyEnum::SICKLE, $proficiencies);
        $this->assertContains(ProficiencyEnum::DAGGER, $proficiencies);
        $this->assertContains(ProficiencyEnum::DART, $proficiencies);
        $this->assertContains(ProficiencyEnum::SPEAR, $proficiencies);
        $this->assertContains(ProficiencyEnum::HERBALISM_KIT, $proficiencies);
        $this->assertContains(ProficiencyEnum::LONG_BOW, $proficiencies);
        $this->assertContains(ProficiencyEnum::LONG_SWORD, $proficiencies);
        $this->assertContains(ProficiencyEnum::SHORT_SWORD, $proficiencies);
        $this->assertContains(ProficiencyEnum::SHORT_BOW, $proficiencies);
    }

    /**
     * @test
     * @covers
     */
    public function checkStats(): void
    {
        $this->assertSame(66, $this->characterUnderTest->getHitPoints());
        $this->assertSame(4, $this->characterUnderTest->getProficiencyBonus());
        $this->assertSame(12, $this->characterUnderTest->getArmorClassWithoutArmor());
        $this->assertSame(2, $this->characterUnderTest->getInitiative());
        $this->assertSame(12, $this->characterUnderTest->getNightvision());
        $this->assertSame(6, $this->characterUnderTest->getSpeed());
    }

    /**
     * @test
     * @covers
     */
    public function checkLanguages(): void
    {
        $this->assertSame(['common', 'elf', 'druid', 'dwarf', 'sylvan', 'primordial'], $this->characterUnderTest->getLanguages());
    }

    /**
     * @test
     * @covers
     */
    public function checkHitDices(): void
    {
        $this->assertSame(['D8' => 9], $this->characterUnderTest->getHitDices());
    }

    /**
     * @test
     * @covers
     */
    public function checkActiveSkills(): void
    {
        $activeSkills = \array_map('get_class', $this->characterUnderTest->getActiveSkills());

        $this->assertContains(FeyAncestry::class, $activeSkills);
        $this->assertContains(Spellcasting::class, $activeSkills);
        $this->assertContains(CombatWildShape::class, $activeSkills);
        $this->assertContains(CircleForms::class, $activeSkills);
        $this->assertContains(PrimalStrike::class, $activeSkills);
        $this->assertContains(FeatWarCaster::class, $activeSkills);
    }

    /**
     * @test
     * @covers
     */
    public function checkPassiveSkills(): void
    {
        $passiveSkills = \array_map('get_class', $this->characterUnderTest->getPassiveSkills());

        $this->assertContains(KeenSenses::class, $passiveSkills);
        $this->assertContains(Trance::class, $passiveSkills);
        $this->assertContains(ElfWeaponTraining::class, $passiveSkills);
        $this->assertContains(Cantrip::class, $passiveSkills);
        $this->assertContains(BonusLanguage::class, $passiveSkills);
        $this->assertContains(Druidic::class, $passiveSkills);
        $this->assertContains(WildShape::class, $passiveSkills);
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
                'spellCount' => 12
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

        $data = \file_get_contents(__DIR__ . '/data/anwen.json');
        $data = \json_decode($data, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception('Invalid character data json.');
        }

        $this->characterUnderTest = CharacterFactory::createFromArray($data);
    }
}
