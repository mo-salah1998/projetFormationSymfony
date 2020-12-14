<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/index", name="app_index")
     * @IsGranted("ROLE_USER")
     */
    public function index(): Response
    {

        return $this->render('index/index.html.twig', [
            'controller_name' => 'IndexController',
        ]);
    }

}
