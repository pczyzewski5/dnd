<?php

declare(strict_types=1);

namespace App\Controller;

use App\Command\UploadFile;
use App\Command\UploadFileHandler;
use App\Form\ItemCardForm;
use App\ItemCard\Command\CreateItemCard;
use App\ItemCard\Command\CreateItemCardHandler;
use App\ItemCard\Command\DeleteItemCard;
use App\ItemCard\Command\DeleteItemCardHandler;
use App\ItemCard\Command\UpdateItemCard;
use App\ItemCard\Command\UpdateItemCardHandler;
use App\ItemCard\Entity\ItemCard;
use App\ItemCard\Query\GetItemCard;
use App\ItemCard\Query\GetItemCardBackHtml;
use App\ItemCard\Query\GetItemCardBackHtmlHandler;
use App\ItemCard\Query\GetItemCardFrontHtml;
use App\ItemCard\Query\GetItemCardFrontHtmlHandler;
use App\ItemCard\Query\GetItemCardHandler;
use App\ItemCard\Query\GetItemCardsForList;
use App\ItemCard\Query\GetItemCardsForListHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

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
                    $form->getData()[ItemCardForm::ITEM_CATEGORY_FIELD],
                    $this->getUser()->getId(),
                    $image
                )
            );

            return $this->redirectToRoute('item_card_read', ['id' => $id->toRfc4122()]);
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

    #[Route('/dm/item_card/{id}/update', 'item_card_update', methods: [Request::METHOD_GET, Request::METHOD_POST])]
    public function update(
        Request $request,
        UploadFileHandler $uploadFileHandler,
        GetItemCardHandler $getItemCardHandler,
        UpdateItemCardHandler $updateItemCardHandler,
        GetItemCardFrontHtmlHandler $getItemCardFrontHtmlHandler,
        GetItemCardBackHtmlHandler $getItemCardBackHtmlHandler
    ): Response {
        $id = $request->get('id');
        $itemCard = $getItemCardHandler->handle(
            new GetItemCard(
                Uuid::fromRfc4122($id)
            )
        );
        $form = $this->createForm(
            ItemCardForm::class,
            [
                ItemCardForm::ITEM_CATEGORY_FIELD => $itemCard->getCategory()->value,
                ItemCardForm::ITEM_TITLE_FIELD => $itemCard->getTitle(),
                ItemCardForm::ITEM_DESCRIPTION_FIELD => $itemCard->getDescription(),
                ItemCardForm::ITEM_ORIGIN_FIELD => $itemCard->getOrigin(),
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form->getData()[ItemCardForm::ITEM_IMAGE_FIELD];
            if (null !== $image) {
                $image = $uploadFileHandler->handle(new UploadFile($image));
            }

            $updateItemCardHandler->handle(
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

        $itemCardFrontHtml = $getItemCardFrontHtmlHandler->handle(
            new GetItemCardFrontHtml(
                Uuid::fromRfc4122($id)
            )
        );
        $itemCardBackHtml = $getItemCardBackHtmlHandler->handle(
            new GetItemCardBackHtml(
                Uuid::fromRfc4122($id)
            )
        );

        return $this->render('item_card/create.html.twig', [
            'item_card_form' => $form,
            'itemCardFrontHtml' => $itemCardFrontHtml,
            'itemCardBackHtml'  => $itemCardBackHtml,
        ]);
    }

    #[Route('/dm/item_card/{id}', 'item_card_read', methods: [Request::METHOD_GET])]
    public function read(
        Request $request,
        GetItemCardFrontHtmlHandler $getItemCardFrontHtmlHandler,
        GetItemCardBackHtmlHandler $getItemCardBackHtmlHandler
    ): Response {
        $id = Uuid::fromRfc4122(
            $request->get('id')
        );
        $itemCardFrontHtml = $getItemCardFrontHtmlHandler->handle(
            new GetItemCardFrontHtml($id)
        );
        $itemCardBackHtml = $getItemCardBackHtmlHandler->handle(
            new GetItemCardBackHtml($id)
        );

        return $this->render('item_card/read.html.twig', [
            'id' => $id->toRfc4122(),
            'itemCardFrontHtml' => $itemCardFrontHtml,
            'itemCardBackHtml' => $itemCardBackHtml,
        ]);
    }

    #[Route('/dm/item_card/{id}/delete', 'item_card_delete', methods: [Request::METHOD_GET])]
    public function delete(
        Request $request,
        DeleteItemCardHandler $handler
    ): Response {
        $handler->handle(
            new DeleteItemCard(
                Uuid::fromRfc4122(
                    $request->get('id')
                )
            )
        );

        return $this->redirectToRoute('item_card_list');
    }

    #[Route('/dm/item_card/{id}/print', 'item_card_print', methods: [Request::METHOD_GET])]
    public function print(
        Request $request,
        GetItemCardFrontHtmlHandler $getItemCardFrontHtmlHandler,
        GetItemCardBackHtmlHandler $getItemCardBackHtmlHandler
    ): Response {
        return $this->render('item_card/print.html.twig', [
            'itemCardFrontHtml' => $getItemCardFrontHtmlHandler->handle(
                new GetItemCardFrontHtml(
                    Uuid::fromRfc4122(
                        $request->get('id')
                    )
                )
            ),
            'itemCardBackHtml'  => $getItemCardBackHtmlHandler->handle(
                new GetItemCardBackHtml(
                    Uuid::fromRfc4122(
                        $request->get('id')
                    )
                )
            ),
        ]);
    }
}
