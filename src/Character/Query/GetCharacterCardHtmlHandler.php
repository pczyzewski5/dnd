<?php

declare(strict_types=1);

namespace App\Character\Query;

use App\Character\CharacterFactory;
use App\CharacterCard\CharacterCardBuilder;
use App\PlayerCharacter\PlayerCharacterRepository;

class GetCharacterCardHtmlHandler
{
    public function __construct(
        private readonly PlayerCharacterRepository $repository,
        private readonly CharacterCardBuilder $builder
    ) {
    }

    public function handle(GetCharacterCardHtml $query): string
    {
        return $this->builder->build(
            CharacterFactory::createFromEntity(
                $this->repository->getOneById(
                    $query->getId()
                )
            )
        );
    }
}
