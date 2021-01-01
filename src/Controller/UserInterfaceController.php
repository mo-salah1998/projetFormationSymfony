<?php

namespace App\Controller;

use App\Repository\CommandeRepository;
use App\Repository\MatiereRepository;
use App\Repository\ParticipantRepository;
use App\Service\panierService;
use Psr\Container\ContainerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;


/**
 * @Route("/user", name="user_")
 * @IsGranted("ROLE_USER")
 */
class UserInterfaceController extends AbstractController
{
    /**
     * @Route("/interface", name="interface")
     */
    public function index(MatiereRepository $matiereRepository,ParticipantRepository $participantRepository,Session $session): Response
    {
        $user = $participantRepository->findOneByEmail($session->get('app_login_from_last_email'));
       // dd($user->getUser());
        return $this->render('user_interface/index.html.twig', [
            'controller_name' => 'UserInterfaceController',
            'matieres' => $matiereRepository->findAll(),
            //'mesMatier'=> $user->getUser(),
        ]);
    }

    /**
     * @Route ("/panier/add/{id}" , name="panier_add")
     */
    public function add($id, panierService $panierService)
    {
        $panierService->add($id);
        return $this->redirectToRoute("user_panier");

    }

    /**
     * @Route ("/panier" , name="panier")
     */
    public function panier(panierService $panierService)
    {
        return $this->render('user_interface/panier.html.twig', [
            'items' => $panierService->getFullPanier(),
            'total' => $panierService->getTotal(),
        ]);
    }

    /**
     * @Route ("/panier/remove/{id}" , name="panier_remove")
     */
    public function remove($id, panierService $panierService)
    {
        $panierService->remove($id);
        return $this->redirectToRoute("user_panier");
    }

    /**
     * @Route ("/panier/create-checkout" , name="panier_checkout")
     */
    public function checkout(panierService $panierService)
    {

        \Stripe\Stripe::setApiKey('sk_test_51I4RZtFM65ZAImMvBBenD5Fkv1fFNqJ8Fr7u1MmGQjmzbDQKuSIJSeEJqHNePQegUVhA0gGHcBcYPKKJr6Ttlwk700eYwIaTKs');
        $checkout_session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'unit_amount' => ($panierService->getTotal())*100,
                    'product_data' => [
                        'name' => 'total =',

                    ],
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => $this->generateUrl('user_checkout_success', [], UrlGeneratorInterface::ABSOLUTE_URL),
            'cancel_url' => $this->generateUrl('user_checkout_faild', [], UrlGeneratorInterface::ABSOLUTE_URL),
        ]);

        return new JsonResponse(['id' => $checkout_session->id]);
    }

    /**
     * @Route ("/panier/checkout/success" , name="checkout_success")
     */
    public function succes(panierService $panierService)
    {

        $panierService->commender();
        return $this->render('user_interface/succes.html.twig',[
            'vider'=>$panierService->removeAllItem()
        ]);
    }

    /**
     * @Route ("/panier/checkout/faild" , name="checkout_faild")
     */
    public function faild()
    {
        return $this->redirectToRoute("user_panier");
    }
}
