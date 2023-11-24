<?php

declare(strict_types=1);

namespace App\Controller;

use App\CommandBus\CommandBus;
use App\Form\ItemCardForm;
use App\QueryBus\QueryBus;
use DND\Domain\Command\CreateItemCard;
use DND\Domain\Enum\ItemCardCategoryEnum;
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

    public function itemCardList(): Response
    {
        $itemCards = $this->queryBus->handle(
            new GetItemCards()
        );

        return $this->renderForm('item_card/item_card_list.html.twig', [
            'itemCards' => $itemCards,
        ]);
    }

    public function itemCardCreate(Request $request): Response
    {
        $form = $this->createForm(ItemCardForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->commandBus->handle(
                new CreateItemCard(
                    $form->getData()[ItemCardForm::ITEM_TITLE_FIELD],
                    $form->getData()[ItemCardForm::ITEM_DESCRIPTION_FIELD],
                    $form->getData()[ItemCardForm::ITEM_ORIGIN_FIELD],
                    ItemCardCategoryEnum::ITEM(),
                    $this->getUser()->getId()
                )
            );

            return $this->redirectToRoute('item_card_list');
        }

        return $this->renderForm('item_card/create_item_card.html.twig', [
            'item_card_form' => $form
        ]);
    }


    public function updateQuestion(Request $request): Response
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
}
