<?php

declare(strict_types=1);

namespace App\Controller;

use App\CommandBus\CommandBus;
use App\Form\ItemCardForm;
use App\QueryBus\QueryBus;
use DND\Domain\Command\CreateItemCard;
use DND\Domain\Command\DeleteItemCard;
use DND\Domain\Command\UpdateItemCard;
use DND\Domain\Command\UploadFile;
use DND\Domain\Enum\ItemCardCategoryEnum;
use DND\Domain\ItemCard\ItemCard;
use DND\Domain\Query\GetCharacterCardHtml;
use DND\Domain\Query\GetCharactersByOwner;
use DND\Domain\Query\GetItemCard;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CharacterController extends BaseController
{
    private QueryBus $queryBus;
    private CommandBus $commandBus;

    public function __construct(QueryBus $queryBus, CommandBus $commandBus)
    {
        $this->queryBus = $queryBus;
        $this->commandBus = $commandBus;
    }

    public function read(Request $request): Response
    {
        $id = $request->get('id');
        $html = $this->queryBus->handle(new GetCharacterCardHtml($id));

        return $this->renderForm('character/read.html.twig', [
            'characterCardHtml' => $html,
            'id' => $id
        ]);
    }

    public function list(): Response
    {
        $characters = $this->queryBus->handle(
            new GetCharactersByOwner(
                $this->getUser()
            )
        );

        return $this->renderForm('character/list.html.twig', [
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

        return $this->renderForm('item_card/create.html.twig', [
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

        return $this->renderForm('item_card/create.html.twig', [
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

        return $this->renderForm('character/print.html.twig', [
            'characterCardHtml' => $html,
        ]);
    }
}
