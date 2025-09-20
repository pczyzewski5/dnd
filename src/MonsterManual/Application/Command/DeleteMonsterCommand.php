<?php

declare(strict_types=1);

namespace App\MonsterManual\Application\Command;

use App\Command\DeleteFileCommand;
use App\MonsterManual\Infrastructure\Persistance\Entity\Monster;
use App\Service\EntityService;
use Symfony\Component\Uid\Uuid;

class DeleteMonsterCommand
{
    public function __construct(
        private readonly EntityService $entityService,
        private readonly DeleteFileCommand $deleteFileCommand,
    ) {
    }

    public function execute(Uuid $uuid)
    {
        $entity = $this->entityService->getByUuid(
            $uuid,
            Monster::class
        );

        $this->deleteFileCommand->execute(
            $entity->getImage()
        );

        $this->entityService->delete($entity);
    }
}
