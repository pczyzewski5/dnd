<?php

declare(strict_types=1);

namespace App\Controller;

use App\Character\Query\GetCharacterCardHtml;
use App\Character\Query\GetCharactersByOwner;
use App\Character\Query\GetCharactersByOwnerHandler;
use App\Command\UploadFile;
use App\Enum\ItemCardCategoryEnum;
use App\Form\ItemCardForm;
use App\ItemCard\Command\CreateItemCard;
use App\ItemCard\Command\DeleteItemCard;
use App\ItemCard\Command\UpdateItemCard;
use App\ItemCard\Entity\ItemCard;
use App\ItemCard\Query\GetItemCard;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CharacterController extends AbstractController
{
    public function read(Request $request): Response
    {
        $id = $request->get('id');
        $html = $this->queryBus->handle(new GetCharacterCardHtml($id));

        return $this->render('character/read.html.twig', [
            'characterCardHtml' => $html,
            'id' => $id
        ]);
    }

    #[Route('/player/character/list', 'character_list', methods: [Request::METHOD_GET])]
    public function list(GetCharactersByOwnerHandler $getCharactersByOwnerHandler): Response
    {
        $characters = $getCharactersByOwnerHandler->handle(
            new GetCharactersByOwner(
                $this->getUser()
            )
        );

        return $this->render('character/list.html.twig', [
            'characters' => $characters,
        ]);
    }

    public function create(Request $request): Response
    {
        $form = $this->createForm(ItemCardForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form->getData()[ItemCardForm::ITEM_IMAGE_FIELD];
            if (null !== $image) {
                $image = $this->commandBus->handle(new UploadFile($image));
            }

            $id = $this->commandBus->handle(
                new CreateItemCard(
                    $form->getData()[ItemCardForm::ITEM_TITLE_FIELD],
                    $form->getData()[ItemCardForm::ITEM_DESCRIPTION_FIELD],
                    $form->getData()[ItemCardForm::ITEM_ORIGIN_FIELD],
                    ItemCardCategoryEnum::from($form->getData()[ItemCardForm::ITEM_CATEGORY_FIELD]),
                    $this->getUser()->getId(),
                    $image
                )
            );

            return $this->redirectToRoute('item_card_read', ['id' => $id]);
        }

        return $this->render('item_card/create.html.twig', [
            'item_card_form' => $form
        ]);
    }


    public function update(Request $request): Response
    {
        /** @var ItemCard $itemCard */
        $itemCard = $this->queryBus->handle(
            new GetItemCard($request->get('id'),)
        );
        $form = $this->createForm(
            ItemCardForm::class,
            [
                ItemCardForm::ITEM_CATEGORY_FIELD => $itemCard->getCategory()->getValue(),
                ItemCardForm::ITEM_TITLE_FIELD => $itemCard->getTitle(),
                ItemCardForm::ITEM_DESCRIPTION_FIELD => $itemCard->getDescription(),
                ItemCardForm::ITEM_ORIGIN_FIELD => $itemCard->getOrigin(),
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form->getData()[ItemCardForm::ITEM_IMAGE_FIELD];
            if (null !== $image) {
                $image = $this->commandBus->handle(new UploadFile($image));
            }

            $this->commandBus->handle(
                new UpdateItemCard(
                    $itemCard,
                    $form->getData()[ItemCardForm::ITEM_TITLE_FIELD],
                    $form->getData()[ItemCardForm::ITEM_DESCRIPTION_FIELD],
                    $form->getData()[ItemCardForm::ITEM_ORIGIN_FIELD],
                    $form->getData()[ItemCardForm::ITEM_CATEGORY_FIELD],
                    $image
                )
            );

            return $this->redirectToRoute('item_card_read', ['id' => $itemCard->getId()]);
        }

        return $this->render('item_card/create.html.twig', [
            'item_card_form' => $form,
            'itemCard' => $itemCard
        ]);
    }

    public function delete(Request $request): Response
    {
        $this->commandBus->handle(
            new DeleteItemCard(
                $request->get('id')
            )
        );

        return $this->redirectToRoute('item_card_list');
    }

    public function print(Request $request): Response
    {
        $html = $this->queryBus->handle(
            new GetCharacterCardHtml($request->get('id'))
        );

        return $this->render('character/print.html.twig', [
            'characterCardHtml' => $html,
        ]);
    }
}
