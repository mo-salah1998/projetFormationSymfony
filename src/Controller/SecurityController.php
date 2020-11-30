<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{
    public const Last_Email = 'app_login_from_last_email';
    /**
     * @Route("/login", name="app_login", methods={"GET","POST"})
     */
    public function login(): Response
    {
        return $this->render('security/index.html.twig', [
            'controller_name' => 'SecurityController',
        ]);
    }
    /**
     * @Route("/logout", name="app_logout", methods={"GET"})
     */
    public function logout(): Response
    {
        return $this->render('security/index.html.twig', [
            'controller_name' => 'SecurityController',
        ]);
    }
}
