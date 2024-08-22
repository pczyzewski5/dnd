<?php

declare(strict_types=1);

namespace App\Controller;

use App\Command\UploadFile;
use App\Command\UploadFileHandler;
use App\Enum\ItemCardCategoryEnum;
use App\Form\ItemCardForm;
use App\ItemCard\Command\CreateItemCard;
use App\ItemCard\Command\CreateItemCardHandler;
use App\ItemCard\Command\DeleteItemCard;
use App\ItemCard\Command\UpdateItemCard;
use App\ItemCard\Entity\ItemCard;
use App\ItemCard\Query\GetItemCard;
use App\ItemCard\Query\GetItemCardBackHtml;
use App\ItemCard\Query\GetItemCardBackHtmlHandler;
use App\ItemCard\Query\GetItemCardFrontHtml;
use App\ItemCard\Query\GetItemCardFrontHtmlHandler;
use App\ItemCard\Query\GetItemCardsForList;
use App\ItemCard\Query\GetItemCardsForListHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ItemCardController extends AbstractController
{
    #[Route('/dm/item_card/list', 'item_card_list', methods: [Request::METHOD_GET])]
    public function list(GetItemCardsForListHandler $handler): Response
    {
        return $this->render('item_card/list.html.twig', [
            'itemCards' => $handler->handle(
                new GetItemCardsForList()
            ),
        ]);
    }

    #[Route('/dm/item_card/create', 'item_card_create', methods: [Request::METHOD_GET, Request::METHOD_POST])]
    public function create(
        Request $request,
        UploadFileHandler $uploadFileHandler,
        CreateItemCardHandler $createItemCardHandler,
        GetItemCardFrontHtmlHandler $getItemCardFrontHtmlHandler,
        GetItemCardBackHtmlHandler $getItemCardBackHtmlHandler
    ): Response {
        $form = $this->createForm(ItemCardForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form->getData()[ItemCardForm::ITEM_IMAGE_FIELD];
            if (null !== $image) {
                $image = $uploadFileHandler->handle(new UploadFile($image));
            }

            $id = $createItemCardHandler->handle(
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

        $itemCardFrontHtml = $getItemCardFrontHtmlHandler->handle(
            new GetItemCardFrontHtml()
        );
        $itemCardBackHtml = $getItemCardBackHtmlHandler->handle(
            new GetItemCardBackHtml()
        );

        return $this->render('item_card/create.html.twig', [
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

        return $this->render('item_card/create.html.twig', [
            'item_card_form' => $form,
            'itemCardFrontHtml' => $itemCardFrontHtml,
            'itemCardBackHtml'  => $itemCardBackHtml,
        ]);
    }

    #[Route(' /dm/item_card/{id}', 'item_card_read', methods: [Request::METHOD_GET])]
    public function read(Request $request): Response
    {
        $id = $request->get('id');
        $itemCardFrontHtml = $this->queryBus->handle(
            new GetItemCardFrontHtml($id)
        );
        $itemCardBackHtml = $this->queryBus->handle(
            new GetItemCardBackHtml($id)
        );

        return $this->render('item_card/read.html.twig', [
            'id' => $id,
            'itemCardFrontHtml' => $itemCardFrontHtml,
            'itemCardBackHtml' => $itemCardBackHtml,
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

        return $this->render('item_card/print.html.twig', [
            'itemCardFrontHtml' => $itemCardFrontHtml,
            'itemCardBackHtml'  => $itemCardBackHtml,
        ]);
    }
}
