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
use App\Service\Requirement\Checker\Proficiency;
use App\Service\Requirement\Checker\TwoDifferentAsi;
use App\Service\Requirement\Checker\WizardCantrip;
use Exception;

use function sprintf;

class RequirementCheckerService
{
    /** @var AbstractChecker[] */
    private array $checkers;

    public function __construct()
    {
        $this->checkers = [
            new Proficiency(),
            new Language(),
            new TwoDifferentAsi(),
            new Feat(),
            new AsiOrFeat(),
            new Expertise(),
            new FightingStyle(),
            new WizardCantrip()
        ];
    }

    public function check(
        array $requirements,
        CharacterConfigDto $dto
    ): void {
        foreach ($requirements as $requirement) {
            foreach ($this->checkers as $checker) {
                if ($checker->supports($requirement)) {
                    $checker->setRequirement($requirement)
                        ->setCharacterConfig($dto)
                        ->check();

                    return;
                }
            }

            throw new Exception(
                sprintf('Checker for %s, not found.', $requirement->getName())
            );
        }
    }
}
