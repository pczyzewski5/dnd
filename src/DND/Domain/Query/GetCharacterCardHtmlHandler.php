<?php

declare(strict_types=1);

namespace DND\Domain\Query;

use DND\Domain\Character\CharacterRepository;
use DND\Domain\CharacterCard\CharacterCardBuilder;

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
