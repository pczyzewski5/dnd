<?php

declare(strict_types=1);

namespace App\Skill;

use App\CaseConverter;
use App\Character\Character;
use App\Skill\Skills\AbstractSkill;

class SkillFactory
{
    private const SKILLS_NAMESPACE = 'App\Skill\Skills\\';

    public static function create(Character $character, string $skillName): AbstractSkill
    {
        $skillClass = self::SKILLS_NAMESPACE . CaseConverter::normalToUpperCamel($skillName);

        if (false === \class_exists($skillClass)) {
            SkillFilesGenerator::generateFiles($skillName);
        }

        return new $skillClass($character, $skillName);
    }
}
