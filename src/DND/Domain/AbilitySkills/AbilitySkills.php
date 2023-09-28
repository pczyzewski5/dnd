<?php

namespace DND\Domain\AbilitySkills;

use DND\Domain\Enum\AbilitySkillEnum;

class AbilitySkills
{
    private AbilitySkill $acrobatics;
    private AbilitySkill $athletics;
    private AbilitySkill $history;
    private AbilitySkill $insight;
    private AbilitySkill $medicine;
    private AbilitySkill $animalHandling;
    private AbilitySkill $deception;
    private AbilitySkill $perception;
    private AbilitySkill $persuasion;
    private AbilitySkill $nature;
    private AbilitySkill $religion;
    private AbilitySkill $stealth;
    private AbilitySkill $survival;
    private AbilitySkill $investigation;
    private AbilitySkill $arcana;
    private AbilitySkill $performance;
    private AbilitySkill $intimidation;
    private AbilitySkill $sleightOfHands;

    public function __construct(
        AbilitySkill $acrobatics,
        AbilitySkill $athletics,
        AbilitySkill $history,
        AbilitySkill $insight,
        AbilitySkill $medicine,
        AbilitySkill $animalHandling,
        AbilitySkill $deception,
        AbilitySkill $perception,
        AbilitySkill $persuasion,
        AbilitySkill $nature,
        AbilitySkill $religion,
        AbilitySkill $stealth,
        AbilitySkill $survival,
        AbilitySkill $investigation,
        AbilitySkill $arcana,
        AbilitySkill $performance,
        AbilitySkill $intimidation,
        AbilitySkill $sleightOfHands,
    ) {
        $this->acrobatics = $acrobatics;
        $this->athletics = $athletics;
        $this->history = $history;
        $this->insight = $insight;
        $this->medicine = $medicine;
        $this->animalHandling = $animalHandling;
        $this->deception = $deception;
        $this->perception = $perception;
        $this->persuasion = $persuasion;
        $this->nature = $nature;
        $this->religion = $religion;
        $this->stealth = $stealth;
        $this->survival = $survival;
        $this->investigation = $investigation;
        $this->arcana = $arcana;
        $this->performance = $performance;
        $this->intimidation = $intimidation;
        $this->sleightOfHands = $sleightOfHands;
    }

    public function toArray(): array
    {
        return [
            AbilitySkillEnum::ACROBATICS => $this->acrobatics,
            AbilitySkillEnum::ATHLETICS => $this->athletics,
            AbilitySkillEnum::HISTORY => $this->history,
            AbilitySkillEnum::INSIGHT => $this->insight,
            AbilitySkillEnum::MEDICINE => $this->medicine,
            AbilitySkillEnum::ANIMAL_HANDLING => $this->animalHandling,
            AbilitySkillEnum::DECEPTION => $this->deception,
            AbilitySkillEnum::PERCEPTION => $this->perception,
            AbilitySkillEnum::PERSUASION => $this->persuasion,
            AbilitySkillEnum::NATURE => $this->nature,
            AbilitySkillEnum::RELIGION => $this->religion,
            AbilitySkillEnum::STEALTH => $this->stealth,
            AbilitySkillEnum::SURVIVAL => $this->survival,
            AbilitySkillEnum::INVESTIGATION => $this->investigation,
            AbilitySkillEnum::ARCANA => $this->arcana,
            AbilitySkillEnum::PERFORMANCE => $this->performance,
            AbilitySkillEnum::INTIMIDATION => $this->intimidation,
            AbilitySkillEnum::SLEIGHT_OF_HANDS => $this->sleightOfHands,
        ];
    }
}