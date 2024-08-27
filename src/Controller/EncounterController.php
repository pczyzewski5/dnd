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

use function base64_decode;

class EncounterController extends AbstractController
{
    #[Route(
        '/encounter',
        'encounter',
        methods: [Request::METHOD_GET]
    )]
    public function index(EncounterCache $encounterCache): Response
    {
        $encounter = $encounterCache->isExist()
            ? $encounterCache->get()
            : new Encounter();

        $encounterCache->save($encounter);

        return $this->render('encounter/index.html.twig', [
            'encounter' => $encounter,
        ]);
    }

    #[Route(
        '/encounter/delete',
        'encounter_delete',
        methods: [Request::METHOD_GET]
    )]
    public function encounterDelete(EncounterCache $encounterCache): Response
    {
        $encounterCache->deleteEncounter();

        return $this->redirectToRoute('encounter');
    }

    #[Route(
        '/encounter/participant/monster/{monsterId}/add',
        'participant_add',
        methods: [Request::METHOD_GET]
    )]
    public function participantAdd
    (
        Request $request,
        Uuid $monsterId,
        EntityService $entityService,
        EncounterCache $encounterCache,
    ): Response {
        $encounter = $encounterCache->isExist()
            ? $encounterCache->get()
            : new Encounter();

        $encounter->getParticipants()->add(
            EncounterParticipantFactory::createFromMonster(
                $entityService->getByUuid($monsterId, Monster::class),
            )
        );

        $encounterCache->save($encounter);

        $route = $request->headers->get('referer');

        return $this->redirect($route);
    }

    #[Route(
        '/encounter/participant/{participantId}/delete',
        'participant_delete',
        methods: [Request::METHOD_GET]
    )]
    public function participantDelete
    (
        EncounterCache $encounterCache,
        int $participantId,
    ) : Response {
        $encounter = $encounterCache->get();

        $encounter->getParticipants()->remove($participantId);

        $encounterCache->save($encounter);

        return $this->redirectToRoute('encounter');
    }

    #[Route(
        '/encounter/participant/{participantId}/hp/{hp}/add',
        'participant_hp_add',
        methods: [Request::METHOD_GET]
    )]
    public function participantHpAdd
    (
        EncounterCache $encounterCache,
        int $participantId,
        int $hp
    ): Response {
        $encounter = $encounterCache->get();

        $encounter->getParticipants()->get($participantId)->getHp()->add($hp);

        $encounterCache->save($encounter);

        return $this->redirectToRoute('encounter');
    }

    #[Route(
        '/encounter/participant/{participantId}/hp/{hp}/remove',
        'participant_hp_remove',
        methods: [Request::METHOD_GET]
    )]
    public function participantHpRemove
    (
        EncounterCache $encounterCache,
        int $participantId,
        int $hp
    ): Response {
        $encounter = $encounterCache->get();

        $encounter->getParticipants()->get($participantId)->getHp()->remove($hp);

        $encounterCache->save($encounter);

        return $this->redirectToRoute('encounter');
    }

    #[Route(
        '/encounter/participant/{participantId}/hp/rollback',
        'participant_hp_rollback',
        methods: [Request::METHOD_GET]
    )]
    public function participantHpRollback
    (
        EncounterCache $encounterCache,
        int $participantId,
    ): Response {
        $encounter = $encounterCache->get();

        $encounter->getParticipants()->get($participantId)->getHp()->rollbackLastChange();

        $encounterCache->save($encounter);

        return $this->redirectToRoute('encounter');
    }

    #[Route(
        '/encounter/participant/{participantId}/duplicate',
        'participant_duplicate',
        methods: [Request::METHOD_GET]
    )]
    public function participantDuplicate
    (
        EncounterCache $encounterCache,
        int $participantId,
    ): Response {
        $encounter = $encounterCache->get();

        $encounter->getParticipants()->duplicate($participantId);

        $encounterCache->save($encounter);

        return $this->redirectToRoute('encounter');
    }

    #[Route(
        '/encounter/participant/{participantId}/note/{note}/save',
        'participant_note_set',
        methods: [Request::METHOD_GET]
    )]
    public function participantNoteSet
    (
        EncounterCache $encounterCache,
        int $participantId,
        string $note,
    ): Response {
        $encounter = $encounterCache->get();

        $encounter->getParticipants()->get($participantId)->setNote(
            $note === ':note'
                ? ''
                : base64_decode($note, true)
        );

        $encounterCache->save($encounter);

        return $this->redirectToRoute('encounter');
    }

    #[Route(
        '/encounter/participant/{participantId}/swap/{swapId}',
        'participant_swap',
        methods: [Request::METHOD_GET]
    )]
    public function participantSwap
    (
        EncounterCache $encounterCache,
        int $participantId,
        int $swapId,
    ): Response {
        $encounter = $encounterCache->get();

        $encounter->getParticipants()->swap($participantId, $swapId);

        $encounterCache->save($encounter);

        return $this->redirectToRoute('encounter');
    }
}
