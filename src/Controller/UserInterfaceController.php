<?php

namespace App\Controller;

use App\Repository\MatiereRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/user", name="user_")
 */
class UserInterfaceController extends AbstractController
{
    /**
     * @Route("/interface", name="interface")
     */
    public function index(MatiereRepository $matiereRepository): Response
    {
        return $this->render('user_interface/index.html.twig', [
            'controller_name' => 'UserInterfaceController',
            'matieres' => $matiereRepository->findAll(),
        ]);
    }

    /**
     * @Route ("/panier/add/{id}" , name="cart_add")
     */
    public function add($id, Request $request)
    {

        $session = $request->getSession();

        $panier = $session->get('panier', []);

        $panier[$id] = 1;

        $session->set('panier', $panier);

        dd($session->get('panier'));

    }
}
