<?php

declare(strict_types=1);

namespace App\Controller;

use App\Character\Query\GetCharacterCardHtml;
use App\Character\Query\GetCharacterCardHtmlHandler;
use App\Character\Query\GetCharactersByOwner;
use App\Character\Query\GetCharactersByOwnerHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

class CharacterController extends AbstractController
{
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
    public function read(Request $request, GetCharacterCardHtmlHandler $handler): Response
    {
        return $this->render('character/read.html.twig', [
            'characterCardHtml' => $handler->handle(
                new GetCharacterCardHtml(
                    Uuid::fromRfc4122($request->get('id'))
                )
            ),
            'id' => $request->get('id')
        ]);
    }

    #[Route('/player/character/{id}/print', 'character_print', methods: [Request::METHOD_GET])]
    public function print(Request $request, GetCharacterCardHtmlHandler $handler): Response
    {
        return $this->render('character/print.html.twig', [
            'characterCardHtml' => $handler->handle(
                new GetCharacterCardHtml(
                    Uuid::fromRfc4122($request->get('id'))
                )
            ),
        ]);
    }
}
