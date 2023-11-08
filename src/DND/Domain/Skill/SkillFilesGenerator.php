<?php

namespace DND\Domain\Skill;

use App\CaseConverter;

class SkillFilesGenerator
{
    private const TEMPLATE_DIR = 'templates/skill_templates/';
    private const SKILL_TEMPLATE_FILE = 'SkillTemplate.php';
    private const CLASS_DIR = __DIR__ . '/Skills/';

    public static function generateFiles(string $skillName): void
    {
        self::generateClass($skillName);
        self::generateTwigTemplate($skillName);
    }

    private static function generateClass(string $skillName): void
    {
        $className = CaseConverter::normalToUpperCamel($skillName);

        $body = \file_get_contents(self::CLASS_DIR . self::SKILL_TEMPLATE_FILE);
        $body = \str_replace('SkillTemplate', $className, $body);

        $filepath = \sprintf('%s%s.php', self::CLASS_DIR, $className);

        \file_put_contents($filepath, $body);
    }

    private static function generateTwigTemplate(string $skillName): void
    {
        $filepath = \sprintf(
            '%s%s.html.twig',
            self::TEMPLATE_DIR,
            CaseConverter::normalToSnake($skillName)
        );

        \file_put_contents($filepath, "<b>{ $skillName }</b> - ");
    }
}
