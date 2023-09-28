<?php

namespace DND\Domain\Skills;

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

    public function __construct()
    {
        $this->acrobatics = new AbilitySkill();
        $this->athletics = new AbilitySkill();
        $this->history = new AbilitySkill();
        $this->insight = new AbilitySkill();
        $this->medicine = new AbilitySkill();
        $this->animalHandling = new AbilitySkill();
        $this->deception = new AbilitySkill();
        $this->perception = new AbilitySkill();
        $this->persuasion = new AbilitySkill();
        $this->nature = new AbilitySkill();
        $this->religion = new AbilitySkill();
        $this->stealth = new AbilitySkill();
        $this->survival = new AbilitySkill();
        $this->investigation = new AbilitySkill();
        $this->arcana = new AbilitySkill();
        $this->performance = new AbilitySkill();
        $this->intimidation = new AbilitySkill();
        $this->sleightOfHands = new AbilitySkill();
    }

    public function getAcrobatics(): AbilitySkill
    {
        return $this->acrobatics;
    }

    public function getAthletics(): AbilitySkill
    {
        return $this->athletics;
    }

    public function getHistory(): AbilitySkill
    {
        return $this->history;
    }

    public function getInsight(): AbilitySkill
    {
        return $this->insight;
    }

    public function getMedicine(): AbilitySkill
    {
        return $this->medicine;
    }

    public function getAnimalHandling(): AbilitySkill
    {
        return $this->animalHandling;
    }

    public function getDeception(): AbilitySkill
    {
        return $this->deception;
    }

    public function getPerception(): AbilitySkill
    {
        return $this->perception;
    }

    public function getPersuasion(): AbilitySkill
    {
        return $this->persuasion;
    }

    public function getNature(): AbilitySkill
    {
        return $this->nature;
    }

    public function getReligion(): AbilitySkill
    {
        return $this->religion;
    }

    public function getStealth(): AbilitySkill
    {
        return $this->stealth;
    }

    public function getSurvival(): AbilitySkill
    {
        return $this->survival;
    }

    public function getInvestigation(): AbilitySkill
    {
        return $this->investigation;
    }

    public function getArcana(): AbilitySkill
    {
        return $this->arcana;
    }

    public function getPerformance(): AbilitySkill
    {
        return $this->performance;
    }

    public function getIntimidation(): AbilitySkill
    {
        return $this->intimidation;
    }

    public function getSleightOfHands(): AbilitySkill
    {
        return $this->sleightOfHands;
    }

    public function toArray(): array
    {
        return [
            'acrobatics' => $this->acrobatics,
            'athletics' => $this->athletics,
            'history' => $this->history,
            'insight' => $this->insight,
            'medicine' => $this->medicine,
            'animalHandling' => $this->animalHandling,
            'deception' => $this->deception,
            'perception' => $this->perception,
            'persuasion' => $this->persuasion,
            'nature' => $this->nature,
            'religion' => $this->religion,
            'stealth' => $this->stealth,
            'survival' => $this->survival,
            'investigation' => $this->investigation,
            'arcana' => $this->arcana,
            'performance' => $this->performance,
            'intimidation' => $this->intimidation,
            'sleightOfHands' => $this->sleightOfHands,
        ];
    }
}