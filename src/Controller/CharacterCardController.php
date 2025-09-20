<?php

declare(strict_types=1);

namespace App\Controller;

use App\Character\Query\GetCharacterCardBackHtmlQuery;
use App\Character\Query\GetCharacterCardFrontHtmlQuery;
use App\Character\Query\GetCharactersByOwner;
use App\Character\Query\GetCharactersByOwnerHandler;
use App\Form\PlayerCharacterForm;
use App\PlayerCharacter\Entity\PlayerCharacter;
use App\Service\EntityService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

class CharacterCardController extends AbstractController
{
    #[Route('/player/character/create', 'player_character_create', methods: [Request::METHOD_GET, Request::METHOD_POST])]
    public function create(
        Request $request,
        EntityService $entityService
    ): Response {
        $form = $this->createForm(PlayerCharacterForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var PlayerCharacter $pc */
            $pc = $form->getData();
            $pc->setId(Uuid::v1());
            $pc->setCreatedAt(new \DateTimeImmutable());
            $entityService->persist($form->getData());


            return $this->redirectToRoute('character_list');
        }

        return $this->render('character/create.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/player/character/list', 'character_list', methods: [Request::METHOD_GET])]
    public function list(GetCharactersByOwnerHandler $getCharactersByOwnerHandler): Response
    {
        return $this->render('character/list.html.twig', [
            'characters' => $getCharactersByOwnerHandler->handle(
                new GetCharactersByOwner(
                    $this->getUser()
                )
            )
        ]);
    }

    #[Route('/player/character/{id}', 'character_read', methods: [Request::METHOD_GET])]
    public function read(
        Request $request,
        GetCharacterCardFrontHtmlQuery $frontHtmlQuery,
        GetCharacterCardBackHtmlQuery $backHtmlQuery
    ): Response {
        return $this->render('character/read.html.twig', [
            'characterCardFrontHtml' => $frontHtmlQuery->execute(
                    Uuid::fromRfc4122($request->get('id'))
            ),
            'characterCardBackHtml' => $backHtmlQuery->execute(
                    Uuid::fromRfc4122($request->get('id'))
            ),
            'id' => $request->get('id')
        ]);
    }

    #[Route('/player/character/{id}/print', 'character_print', methods: [Request::METHOD_GET])]
    public function print(Request $request, GetCharacterCardFrontHtmlQuery $query): Response
    {
        return $this->render('character/print.html.twig', [
            'characterCardHtml' => $query->execute(
                    Uuid::fromRfc4122($request->get('id'))
            ),
        ]);
    }
}
