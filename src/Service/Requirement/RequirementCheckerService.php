<?php

declare(strict_types=1);

namespace App\Service\Requirement;

use App\Dto\CharacterConfigDto;
use App\Service\Requirement\Checker\AbstractChecker;
use App\Service\Requirement\Checker\AsiOrFeat;
use App\Service\Requirement\Checker\Expertise;
use App\Service\Requirement\Checker\Feat;
use App\Service\Requirement\Checker\FightingStyle;
use App\Service\Requirement\Checker\Language;
use App\Service\Requirement\Checker\OneArtisanTool;
use App\Service\Requirement\Checker\OneByTwoAndDifferentByOneAsi;
use App\Service\Requirement\Checker\Proficiency;
use App\Service\Requirement\Checker\TwoDifferentAsi;
use App\Service\Requirement\Checker\WizardCantrip;
use Exception;

use function sprintf;

class RequirementCheckerService
{
    /** @var AbstractChecker[] */
    private array $checkers;

    public function __construct(
        Proficiency $proficiency,
    )
    {
        $this->checkers = [
            $proficiency,
            new Language(),
            new TwoDifferentAsi(),
            new Feat(),
            new AsiOrFeat(),
            new Expertise(),
            new FightingStyle(),
            new WizardCantrip(),
            new OneByTwoAndDifferentByOneAsi(),
            new OneArtisanTool(),
        ];
    }

    public function check(
        array              $requirements,
        CharacterConfigDto $dto
    ): void {
        foreach ($requirements as $requirement) {
            $checked = false;

            foreach ($this->checkers as $checker) {
                if ($checker->supports($requirement)) {
                    $checker->setRequirement($requirement)
                        ->setCharacterConfig($dto)
                        ->check();

                    $checked = true;
                }
            }

            if (false === $checked) {
                throw new Exception(
                    sprintf('Checker for %s, not found.', $requirement->getName())
                );
            }
        }
    }
}
