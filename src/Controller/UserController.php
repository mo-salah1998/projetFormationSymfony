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
        //dd($tab);
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
            'items'=> $participantRepository->findAll() ,
        ]);
    }
    /**
     * @Route("/admin", name="admin_show")
     */
    public function adminShow(ParticipantRepository $participantRepository): Response
    {
        //dd($tab);
        return $this->render('user/admin.html.twig', [
            'controller_name' => 'UserController',
            'items'=> $participantRepository->findAll() ,
        ]);
    }
}
