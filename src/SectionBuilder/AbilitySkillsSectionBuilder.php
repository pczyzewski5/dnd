<?php

namespace App\SectionBuilder;

use App\Character\Character;
use App\Service\AbilityService;
use Twig\Environment;
use function var_dump;

class AbilitySkillsSectionBuilder extends AbstractSectionBuilder
{
    public function __construct(
        private readonly AbilityService $abilityService,
        Character $character,
        Environment $twig
    )
    {
        parent::__construct($character, $twig);
    }

    public function build(bool $printMode = false): string
    {
        $context =  [
            'abilityService' => $this->abilityService,
            'abilitySkills' => $this->character->abilitySkills,
            'printMode' => $printMode,
        ];

        return $this->twig->render(
            'character_card/sections/ability_skills.html.twig',
            $context
        );
    }
}
