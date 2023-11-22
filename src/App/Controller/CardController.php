<?php

declare(strict_types=1);

namespace App\Controller;

use App\CommandBus\CommandBus;
use App\Form\ItemCardForm;
use App\QueryBus\QueryBus;
use Symfony\Component\HttpFoundation\Response;

class CardController extends BaseController
{
    private QueryBus $queryBus;
    private CommandBus $commandBus;

    public function __construct(QueryBus $queryBus, CommandBus $commandBus)
    {
        $this->queryBus = $queryBus;
        $this->commandBus = $commandBus;
    }

    public function cards(): Response
    {
        return $this->renderForm('card/cards.html.twig');
    }

    public function card(): Response
    {
        $form = $this->createForm(ItemCardForm::class);
//        $form->handleRequest($request);

//        if ($form->isSubmitted() && $form->isValid()) {
//            $data = $form->getData();
//
//            try {
//                $this->commandBus->handle(
//                    new RegisterUser(
//                        $data[RegisterUserForm::EMAIL_FIELD],
//                        'ROLE_USER',
//                        $data[RegisterUserForm::PASSWORD_FIELD],
//                        false
//                    )
//                );
//            } catch (UserAlreadyExistsException $e) {
//                return $this->renderForm('registration/register.html.twig', [
//                    'register_form' => $form,
//                    'error_message' => 'Account already exists.'
//                ]);
//            }
//
//            return $this->redirectToRoute('register_info');
//        }

        return $this->renderForm('card/card/card.html.twig', [
            'register_form' => $form
        ]);
    }
}
