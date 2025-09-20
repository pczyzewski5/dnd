<?php

declare(strict_types=1);

namespace App\Character\Query;

use App\Builder\CharacterBuilder;
use App\Character\Character;
use App\Mapper\CharacterConfigDtoMapper;
use App\PlayerCharacter\Entity\PlayerCharacter;
use App\PlayerCharacter\Repository\PlayerCharacterRepository;

class GetCharactersByOwnerHandler
{
    public function __construct(
        private readonly PlayerCharacterRepository $repository,
        private readonly CharacterConfigDtoMapper  $characterConfigDtoMapper,
        private readonly CharacterBuilder $characterBuilder,
    )
    {
    }

    /**
     * @return Character[]
     * @todo fixme
     */
    public function handle(GetCharactersByOwner $query): array
    {
        $result = \in_array('ROLE_ADMIN', $query->getUser()->getRoles())
            ? $this->repository->findAll()
            : $this->repository->findByOwner($query->getUser()->getId());

        return $result;
        return array_map(
            function (PlayerCharacter $entity): Character {
                var_dump($entity->getData());exit;
                return $this->characterBuilder->build(
                    $this->characterConfigDtoMapper->fromJson($entity->getData()),
                );
            },
            $result
        );
    }
}
