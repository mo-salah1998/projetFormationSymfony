<?php

namespace App\Controller;

use App\Repository\ParticipantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/user", name="user_")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/show", name="show")
     */
    public function index(ParticipantRepository $participantRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
            'users'=> $participantRepository->findBy(
                ['roles' => '["ROLE_ADMIN"]']
            ),
        ]);
    }
}
