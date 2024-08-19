<?php

declare(strict_types=1);

namespace App\Controller;

use App\Form\RegisterUserForm;
use App\User\Exception\UserAlreadyExistsException;
use DND\Domain\Command\RegisterUser;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RegistrationController extends BaseController
{
    public function register(Request $request): Response
    {
        $form = $this->createForm(RegisterUserForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            try {
                $this->commandBus->handle(
                    new RegisterUser(
                        $data[RegisterUserForm::EMAIL_FIELD],
                        $data[RegisterUserForm::USERNAME_FIELD],
                        'ROLE_PLAYER',
                        $data[RegisterUserForm::PASSWORD_FIELD],
                        false
                    )
                );
            } catch (UserAlreadyExistsException $e) {
                return $this->renderForm('registration/register.html.twig', [
                    'register_form' => $form,
                    'error_message' => 'Account already exists.'
                ]);
            }

            return $this->redirectToRoute('register_info');
        }

        return $this->renderForm('registration/register.html.twig', [
            'register_form' => $form
        ]);
    }

    public function registerInfo()
    {
        return $this->renderForm('registration/register_info.html.twig');
    }
}
