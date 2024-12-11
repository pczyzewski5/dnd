<?php

declare(strict_types=1);

namespace App\Character\Query;

use App\Character\CharacterFactory;
use App\CharacterCard\CharacterCardHtmlBuilder;
use App\PlayerCharacter\Entity\PlayerCharacter;
use App\Service\EntityService;
use Symfony\Component\Uid\Uuid;

class GetCharacterCardFrontHtmlQuery
{
    public function __construct(
        private readonly EntityService $entityService,
        private readonly CharacterCardHtmlBuilder $builder
    ) {
    }

    public function execute(Uuid $id, bool $printMode = false): string
    {
        return $this->builder->getFrontpage(
            CharacterFactory::createFromEntity(
                $this->entityService->getByUuid($id, PlayerCharacter::class),
            ),
            $printMode
        );
    }
}
