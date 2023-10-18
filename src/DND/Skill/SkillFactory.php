<?php

namespace DND\Skill;

use App\CaseConverter;
use DND\Character\Character;
use DND\Skill\Skills\AbstractSkill;

class SkillFactory
{
    private const SKILLS_NAMESPACE = 'DND\Skill\Skills\\';

    public static function create(Character $character, string $skillName, int $grantLevel): AbstractSkill
    {
        $skillClass = self::getSkillClass($skillName);

        if (false === \class_exists($skillClass)) {
            SkillFilesGenerator::generateFiles($skillName);
        }

        return new $skillClass($character, $skillName, $grantLevel);
    }

    private static function getSkillClass(string $skillName): string
    {
        return self::SKILLS_NAMESPACE . CaseConverter::normalToUpperCamel($skillName);
    }
}
