<?php

declare(strict_types=1);

namespace App\Controller;

use DND\Domain\Command\ActivateUser;
use DND\Domain\Command\DeactivateUser;
use DND\Domain\Command\DeleteUser;
use DND\Domain\Query\GetUsers;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends AbstractController
{
    public function userList(): Response
    {
        return $this->render('super_admin/user_list.html.twig', [
            'users' => $this->queryBus->handle(
                new GetUsers()
            )
        ]);
    }

    public function activateUser(Request $request): Response
    {
        $this->commandBus->handle(
            new ActivateUser(
                $request->get('userId')
            )
        );

        return $this->redirectToRoute('user_list');
    }

    public function deactivateUser(Request $request): Response
    {
        $this->commandBus->handle(
            new DeactivateUser(
                $request->get('userId')
            )
        );

        return $this->redirectToRoute('user_list');
    }

    public function deleteUser(Request $request): Response
    {
        $this->commandBus->handle(
            new DeleteUser(
                $request->get('userId')
            )
        );

        return $this->redirectToRoute('user_list');
    }
}
