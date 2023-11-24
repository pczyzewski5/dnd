<?php

declare(strict_types=1);

namespace App\Controller;

use App\CommandBus\CommandBus;
use App\Form\ItemCardForm;
use App\QueryBus\QueryBus;
use DND\Domain\Command\CreateItemCard;
use DND\Domain\Command\DeleteItemCard;
use DND\Domain\Command\UploadFile;
use DND\Domain\Enum\ItemCardCategoryEnum;
use DND\Domain\Query\GetItemCard;
use DND\Domain\Query\GetItemCards;
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
        $itemCard = $this->queryBus->handle(
            new GetItemCard(
                $request->get('id')
            )
        );

        return $this->renderForm('item_card/read.html.twig', [
            'itemCard' => $itemCard,
        ]);
    }

    public function list(): Response
    {
        $itemCards = $this->queryBus->handle(
            new GetItemCards()
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
            $image = $this->commandBus->handle(
                new UploadFile($form->getData()[ItemCardForm::ITEM_IMAGE_FIELD])
            );

            $this->commandBus->handle(
                new CreateItemCard(
                    $form->getData()[ItemCardForm::ITEM_TITLE_FIELD],
                    $form->getData()[ItemCardForm::ITEM_DESCRIPTION_FIELD],
                    $form->getData()[ItemCardForm::ITEM_ORIGIN_FIELD],
                    ItemCardCategoryEnum::from($form->getData()[ItemCardForm::ITEM_CATEGORY_FIELD]),
                    $this->getUser()->getId(),
                    $image
                )
            );

            return $this->redirectToRoute('item_card_list');
        }

        return $this->renderForm('item_card/create.html.twig', [
            'item_card_form' => $form
        ]);
    }


    public function update(Request $request): Response
    {
        $category = CategoryEnum::fromLowerKey(
            $request->get('category')
        );
        /** @var QuestionWithAnswersDTO $dto */
        $dto = $this->queryBus->handle(
            new GetQuestionWithAnswers(
                $request->get('questionId'),
                $this->getUser()->getId()
            )
        );
        $question = $dto->getQuestion();

        $form = $this->createForm(
            QuestionForm::class,
            [QuestionForm::QUESTION_FIELD => $question->getQuestion()]
        );

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->commandBus->handle(
                new UpdateQuestion(
                    $question->getId(),
                    $form->getData()[QuestionForm::QUESTION_FIELD],
                    $this->getUser()->getId(),
                    $question->getSubcategory()
                )
            );

            return $this->redirectToRoute('question_details', ['category' => $category->getLowerKey(), 'questionId' => $question->getId()]);
        }

        return $this->renderForm('admin/update_question.html.twig', [
            'edit_question_form' => $form,
            'question' => $question,
            'answers' => $dto->getAnswers(),
            'category' => $category
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
}
