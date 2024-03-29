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
use DND\Domain\Query\GetItemCard;
use DND\Domain\Query\GetItemCardBackHtml;
use DND\Domain\Query\GetItemCardFrontHtml;
use DND\Domain\Query\GetItemCardsForList;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ItemCardController extends BaseController
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
        $itemCardFrontHtml = $this->queryBus->handle(
            new GetItemCardFrontHtml($id)
        );
        $itemCardBackHtml = $this->queryBus->handle(
            new GetItemCardBackHtml($id)
        );

        return $this->renderForm('item_card/read.html.twig', [
            'id' => $id,
            'itemCardFrontHtml' => $itemCardFrontHtml,
            'itemCardBackHtml' => $itemCardBackHtml,
        ]);
    }

    public function list(): Response
    {
        $itemCards = $this->queryBus->handle(
            new GetItemCardsForList()
        );

        return $this->renderForm('item_card/list.html.twig', [
            'itemCards' => $itemCards,
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

        $itemCardFrontHtml = $this->queryBus->handle(
            new GetItemCardFrontHtml()
        );
        $itemCardBackHtml = $this->queryBus->handle(
            new GetItemCardBackHtml()
        );

        return $this->renderForm('item_card/create.html.twig', [
            'item_card_form' => $form,
            'itemCardFrontHtml' => $itemCardFrontHtml,
            'itemCardBackHtml'  => $itemCardBackHtml,
        ]);
    }


    public function update(Request $request): Response
    {
        $id = $request->get('id');
        /** @var ItemCard $itemCard */
        $itemCard = $this->queryBus->handle(
            new GetItemCard($id)
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

        $itemCardFrontHtml = $this->queryBus->handle(
            new GetItemCardFrontHtml($id)
        );
        $itemCardBackHtml = $this->queryBus->handle(
            new GetItemCardBackHtml($id)
        );

        return $this->renderForm('item_card/create.html.twig', [
            'item_card_form' => $form,
            'itemCardFrontHtml' => $itemCardFrontHtml,
            'itemCardBackHtml'  => $itemCardBackHtml,
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
        $itemCardFrontHtml = $this->queryBus->handle(
            new GetItemCardFrontHtml(
                $request->get('id')
            )
        );
        $itemCardBackHtml = $this->queryBus->handle(
            new GetItemCardBackHtml(
                $request->get('id')
            )
        );

        return $this->renderForm('item_card/print.html.twig', [
            'itemCardFrontHtml' => $itemCardFrontHtml,
            'itemCardBackHtml'  => $itemCardBackHtml,
        ]);
    }
}
