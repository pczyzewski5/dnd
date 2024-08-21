<?php

declare(strict_types=1);

namespace App\Character\Query;

use App\Character\CharacterRepository;
use App\CharacterCard\CharacterCardBuilder;

class GetCharacterCardHtmlHandler
{
    private CharacterRepository $repository;
    private CharacterCardBuilder $builder;

    public function __construct(CharacterRepository $repository, CharacterCardBuilder $builder)
    {
        $this->repository = $repository;
        $this->builder = $builder;
    }

    public function __invoke(GetCharacterCardHtml $query): string
    {
        return $this->builder->build(
            $this->repository->getOneById($query->getId())
        );
    }
}
