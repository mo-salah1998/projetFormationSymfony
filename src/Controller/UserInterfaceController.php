<?php

namespace App\Controller;

use App\Repository\MatiereRepository;
use App\Service\panierService;
use Psr\Container\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
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
     * @Route ("/panier/add/{id}" , name="panier_add")
     */
    public function add($id,panierService $panierService)
    {
        $panierService->add($id);
        return $this->redirectToRoute("user_panier");

    }

    /**
     * @Route ("/panier" , name="panier")
     */
    public function panier(panierService $panierService)
    {
        return $this->render('user_interface/panier.html.twig',[
            'items' => $panierService->getFullPanier(),
            'total' => $panierService->getTotal(),
        ]);
    }

    /**
     * @Route ("/panier/remove/{id}" , name="panier_remove")
     */
    public function remove( $id,panierService $panierService)
    {
        $panierService->remove($id);
        return $this->redirectToRoute("user_panier");
    }


}
