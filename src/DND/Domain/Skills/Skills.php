<?php

namespace DND\Domain\Skills;

class Skills
{
    private Skill $acrobatics;
    private Skill $athletics;
    private Skill $history;
    private Skill $insight;
    private Skill $medicine;
    private Skill $animalHandling;
    private Skill $deception;
    private Skill $perception;
    private Skill $persuasion;
    private Skill $nature;
    private Skill $religion;
    private Skill $stealth;
    private Skill $survival;
    private Skill $investigation;
    private Skill $arcana;
    private Skill $performance;
    private Skill $intimidation;
    private Skill $sleightOfHands;

    public function __construct()
    {
        $this->acrobatics = new Skill();
        $this->athletics = new Skill();
        $this->history = new Skill();
        $this->insight = new Skill();
        $this->medicine = new Skill();
        $this->animalHandling = new Skill();
        $this->deception = new Skill();
        $this->perception = new Skill();
        $this->persuasion = new Skill();
        $this->nature = new Skill();
        $this->religion = new Skill();
        $this->stealth = new Skill();
        $this->survival = new Skill();
        $this->investigation = new Skill();
        $this->arcana = new Skill();
        $this->performance = new Skill();
        $this->intimidation = new Skill();
        $this->sleightOfHands = new Skill();
    }

    public function getAcrobatics(): Skill
    {
        return $this->acrobatics;
    }

    public function getAthletics(): Skill
    {
        return $this->athletics;
    }

    public function getHistory(): Skill
    {
        return $this->history;
    }

    public function getInsight(): Skill
    {
        return $this->insight;
    }

    public function getMedicine(): Skill
    {
        return $this->medicine;
    }

    public function getAnimalHandling(): Skill
    {
        return $this->animalHandling;
    }

    public function getDeception(): Skill
    {
        return $this->deception;
    }

    public function getPerception(): Skill
    {
        return $this->perception;
    }

    public function getPersuasion(): Skill
    {
        return $this->persuasion;
    }

    public function getNature(): Skill
    {
        return $this->nature;
    }

    public function getReligion(): Skill
    {
        return $this->religion;
    }

    public function getStealth(): Skill
    {
        return $this->stealth;
    }

    public function getSurvival(): Skill
    {
        return $this->survival;
    }

    public function getInvestigation(): Skill
    {
        return $this->investigation;
    }

    public function getArcana(): Skill
    {
        return $this->arcana;
    }

    public function getPerformance(): Skill
    {
        return $this->performance;
    }

    public function getIntimidation(): Skill
    {
        return $this->intimidation;
    }

    public function getSleightOfHands(): Skill
    {
        return $this->sleightOfHands;
    }
}