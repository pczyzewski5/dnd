<?php

declare(strict_types=1);

namespace DND\Domain\Skill;

use App\CaseConverter;
use DND\Domain\Character\Character;
use DND\Domain\Skill\Skills\AbstractSkill;

class SkillFactory
{
    private const SKILLS_NAMESPACE = 'DND\Domain\Skill\Skills\\';

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
