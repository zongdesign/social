<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class LoginController.
 */
class LoginController extends AbstractController
{
    /**
     * @Route("/api/login", name="api_login")
     */
    public function login()
    {
        /** @var User $user */
        $user = $this->getUser();

        return $this->json(
            sprintf('Hello, %s', $user->getNickName()),
            200
        );
    }

    /**
     * @Route("/api/logout", name="api_logout")
     */
    public function logout()
    {
        throw new \Exception('This method can be blank - it will be intercepted by the logout key on your firewall');
    }
}
