<?php

declare(strict_types=1);

namespace App\Controller;

use App\Encounter\Encounter;
use App\Encounter\EncounterCache;
use App\Encounter\EncounterParticipantFactory;
use App\Monster\Entity\Monster;
use App\Service\EntityService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

class EncounterController extends AbstractController
{
    #[Route('/encounter', 'encounter', methods: [Request::METHOD_GET])]
    public function index(EncounterCache $encounterCache): Response
    {
        $encounter = $encounterCache->encounterExist()
            ? $encounterCache->getEncounter()
            : new Encounter();

        return $this->render('encounter/index.html.twig', [
            'encounter' => $encounter,
        ]);
    }

    #[Route('/encounter/participant/add/{uuid}', 'encounter_participant_add', methods: [Request::METHOD_GET])]
    public function participantAdd(
        Uuid $uuid,
        EntityService $entityService,
        EncounterCache $encounterCache,
    ): Response {
        $encounter = $encounterCache->encounterExist()
            ? $encounterCache->getEncounter()
            : new Encounter();

        $encounterCache->saveEncounter(
            $encounter->addParticipant(
                EncounterParticipantFactory::createFromMonster(
                    $entityService->getByUuid($uuid, Monster::class),
                )
            )
        );

        return $this->redirectToRoute('encounter');
    }

    #[Route('/encounter/participant/{participantId}/hp/{hp}/add', 'encounter_participant_add_hp', methods: [Request::METHOD_GET])]
    public function participantAddHP(
        EncounterCache $encounterCache,
        int $participantId,
        int $hp
    ): Response {
        $encounterCache->saveEncounter(
            $encounterCache->getEncounter()
                ->addHp($participantId, $hp)
        );

        return $this->redirectToRoute('encounter');
    }

    #[Route('/encounter/participant/{participantId}/hp/{hp}/remove', 'encounter_participant_remove_hp', methods: [Request::METHOD_GET])]
    public function participantRemoveHp(
        EncounterCache $encounterCache,
        int $participantId,
        int $hp
    ): Response {
        $encounterCache->saveEncounter(
            $encounterCache->getEncounter()
                ->removeHp($participantId, $hp)
        );

        return $this->redirectToRoute('encounter');
    }

    #[Route('/encounter/participant/{participantId}/hp/rollback', 'encounter_participant_hp_rollback', methods: [Request::METHOD_GET])]
    public function participantRollbackHp(
        EncounterCache $encounterCache,
        int $participantId,
    ): Response {
        $encounterCache->saveEncounter(
            $encounterCache->getEncounter()
                ->rollbackLastHpChange($participantId)
        );

        return $this->redirectToRoute('encounter');
    }

    #[Route('/encounter/participant/duplicate/{participantId}', 'encounter_participant_duplicate', methods: [Request::METHOD_GET])]
    public function participantDuplicate(
        EncounterCache $encounterCache,
        int $participantId,
    ): Response {
        $encounterCache->saveEncounter(
            $encounterCache->getEncounter()
                ->duplicateParticipant($participantId)
        );

        return $this->redirectToRoute('encounter');
    }

    #[Route('/encounter/participant/delete/{participantId}', 'encounter_participant_delete', methods: [Request::METHOD_GET])]
    public function participantDelete(
        EncounterCache $encounterCache,
        int $participantId,
    ) : Response {
        $encounterCache->saveEncounter(
            $encounterCache->getEncounter()
                ->removeParticipant($participantId)
        );

        return $this->redirectToRoute('encounter');
    }

    #[Route('/encounter/delete', 'encounter_delete', methods: [Request::METHOD_GET])]
    public function encounterDelete(EncounterCache $encounterCache): Response
    {
        $encounterCache->deleteEncounter();

        return $this->redirectToRoute('encounter');
    }
}
