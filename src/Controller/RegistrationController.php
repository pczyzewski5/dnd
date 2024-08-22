<?php

declare(strict_types=1);

namespace App\Controller;

use App\Exception\UserAlreadyExistsException;
use App\Form\RegisterUserForm;
use App\User\Command\RegisterUser;
use App\User\Command\RegisterUserHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    #[Route('/register', 'register', methods: [Request::METHOD_GET, Request::METHOD_POST])]
    public function register(Request $request, RegisterUserHandler $registerUserHandler): Response
    {
        $form = $this->createForm(RegisterUserForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            try {
                $registerUserHandler->handle(
                    new RegisterUser(
                        $data[RegisterUserForm::EMAIL_FIELD],
                        $data[RegisterUserForm::USERNAME_FIELD],
                        'ROLE_PLAYER',
                        $data[RegisterUserForm::PASSWORD_FIELD],
                        false
                    )
                );
            } catch (UserAlreadyExistsException $e) {
                return $this->render('registration/register.html.twig', [
                    'register_form' => $form,
                    'error_message' => 'Account already exists.'
                ]);
            }

            return $this->redirectToRoute('register_info');
        }

        return $this->render('registration/register.html.twig', [
            'register_form' => $form
        ]);
    }

    #[Route('/register/info', 'register_info', methods: [Request::METHOD_GET])]
    public function registerInfo()
    {
        return $this->render('registration/register_info.html.twig');
    }
}
