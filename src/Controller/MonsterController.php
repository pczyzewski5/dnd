<?php

declare(strict_types=1);

namespace App\Controller;

use App\Form\MonsterForm;
use App\Monster\Entity\Monster;
use App\Service\EntityService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

class MonsterController extends AbstractController
{
    #[Route('/dm/monster/list', 'monster_list', methods: [Request::METHOD_GET])]
    public function list(EntityService $entityService): Response
    {
        return $this->render('monster/list.html.twig', [
            'monsters' => $entityService->findAll(Monster::class)
        ]);
    }

    #[Route('/dm/monster/create', 'monster_create', methods: [Request::METHOD_GET, Request::METHOD_POST])]
    public function create(
        Request $request,
        EntityService $entityService
    ): Response {
        $form = $this->createForm(MonsterForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityService->persist(
                $entity = $form->getData(),
            );

            return $this->redirectToRoute(
                'monster_read',
                ['id' => $entity->getId()->toRfc4122()]
            );
        }

        return $this->render('monster/create.html.twig', [
            'monsterForm' => $form
        ]);
    }

    #[Route('/dm/monster/{id}/update', 'monster_update', methods: [Request::METHOD_GET, Request::METHOD_POST])]
    public function update(Request $request, EntityService $entityService): Response
    {
        $entity = $entityService->getByUuid(
            Uuid::fromRfc4122($request->get('id')),
            Monster::class
        );
        $form = $this->createForm(MonsterForm::class, $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityService->persist(
                $form->getData()
            );

            return $this->redirectToRoute('monster_read', ['id' => $request->get('id')]);
        }

        return $this->render('monster/create.html.twig', [
            'monsterForm' => $form,
            'monsterEntity' => $entity
        ]);
    }

    #[Route('/dm/monster/{id}/delete', 'monster_delete', methods: [Request::METHOD_GET])]
    public function delete(Request $request, EntityService $entityService): Response
    {
        $entityService->deleteByUuid(
            Uuid::fromRfc4122($request->get('id')),
            Monster::class
        );

        return $this->redirectToRoute('monster_list');
    }

    #[Route('/dm/monster/{id}', 'monster_read', methods: [Request::METHOD_GET])]
    public function read(Request $request, EntityService $entityService): Response
    {
        return $this->render('monster/read.html.twig', [
            'monsterEntity' => $entityService->getByUuid(
                Uuid::fromRfc4122($request->get('id')),
                Monster::class
            ),
            'id' => $request->get('id')
        ]);
    }
}
