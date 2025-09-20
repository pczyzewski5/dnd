<?php

declare(strict_types=1);

namespace App\Service\Requirement\Checker;

use App\Dto\LevelConfigDto;
use App\Dto\ProficiencyDto;
use App\Entity\Requirement;
use App\Exception\RequirementException;

use function count;
use function sprintf;
use function ucfirst;

class OneArtisanTool extends AbstractChecker
{
    private const ARTISAN_TOOLS = [
        'alchemists supplies',
        'brewers supplies',
        'calligraphers supplies',
        'carpenters tools',
        'cartographers tools',
        'cobblers tools',
        'cooks utensils',
        'glassblowers tools',
        'jewelers tools',
        'leatherworkers tools',
        'masons tools',
        'painters supplies',
        'potters tools',
        'smiths tools',
        'tinkers tools',
        'weavers tools',
        'woodcarvers tools',
    ];

    public function supports(Requirement $requirement): bool
    {
        return 'one artisan tool' === $requirement->getName();
    }

    public function check(): void
    {
        $level = $this->getConfigValue('level');
        $source = $this->getConfigValue('source');
        $levelConfig = $this->getLevelConfig($level);

        $chosenProficiencies = array_filter(
            $levelConfig->proficiencies,
            fn(ProficiencyDto $dto): bool => $dto->source === $source
        );
        $chosenProficiencies = array_map(
            fn(ProficiencyDto $dto) => strtolower($dto->name),
            $chosenProficiencies
        );
        $chosenArtisanTools = array_intersect($chosenProficiencies, self::ARTISAN_TOOLS);

        if (count($chosenArtisanTools) !== 1) {
            $message = sprintf(
                '%s require to pick proficiency in one of artisan tools: %s, you have picked: %s.',
                ucfirst($source),
                implode(', ', self::ARTISAN_TOOLS),
                implode(', ', $chosenArtisanTools)
            );

            throw RequirementException::requirementNotMet($message);
        }
    }
}
