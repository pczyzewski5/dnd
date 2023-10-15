<?php

namespace DND\Skill;

use App\CaseConverter;

class SkillFilesGenerator
{
    private const TEMPLATE_DIR = 'templates/skill_templates/';
    private const SKILL_TEMPLATE_FILE = 'SkillTemplate.php';
    private const CLASS_DIR = __DIR__ . '/Skills/';

    public static function generateFiles(Skill $skill): void
    {
        self::generateClass($skill);
        self::generateTwigTemplate($skill);
    }

    private static function generateClass(Skill $skill): void
    {
        $className = CaseConverter::normalToUpperCamel($skill->getName());

        $body = \file_get_contents(self::CLASS_DIR . self::SKILL_TEMPLATE_FILE);
        $body = \str_replace('SkillTemplate', $className, $body);

        $filepath = \sprintf(
            '%s%s.php',
            self::CLASS_DIR,
            $className
        );

        \file_put_contents($filepath, $body);
    }

    private static function generateTwigTemplate(Skill $skill): void
    {
        $filepath = \sprintf(
            '%s%s.html.twig',
            self::TEMPLATE_DIR,
            CaseConverter::normalToSnake($skill->getName())
        );
        $content = \sprintf(
            '<b>%s</b> - ',
            $skill->getName()
        );

        \file_put_contents($filepath, $content);
    }
}
