<?php

namespace App\Service;

use App\Entity\Commande;
use App\Repository\CommandeRepository;
use App\Repository\MatiereRepository;
use App\Repository\ParticipantRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class panierService extends AbstractController
{

    protected $session;
    protected $matiereRepository;
    protected $commandeRepository;
    protected $participantRepository;


    /**
     * panierService constructor.
     */
    public function __construct(SessionInterface $session, MatiereRepository $matiereRepository, CommandeRepository $commandeRepository, ParticipantRepository $participantRepository)
    {
        $this->session = $session;
        $this->matiereRepository = $matiereRepository;
        $this->commandeRepository = $commandeRepository;
        $this->participantRepository = $participantRepository;


    }

    public function add(int $id)
    {

        $panier = $this->session->get('panier', []);

        $panier[$id] = 1;

        $this->session->set('panier', $panier);
        // dd($session->get('panier'));
    }

    public function remove(int $id)
    {
        $panier = $this->session->get('panier', []);
        if (!empty($panier[$id])) {
            unset($panier[$id]);
        }
        $this->session->set('panier', $panier);
    }

    public function getFullPanier(): array
    {
        $panier = $this->session->get('panier', []);
        $panierWithData = [];
        foreach ($panier as $id => $quantity) {
            $panierWithData[] = ['matiere' => $this->matiereRepository->find($id)];
        }
        return $panierWithData;
    }

    public function getTotal(): float
    {
        $total = 0;

        foreach ($this->getFullPanier() as $item) {
            $total += $item['matiere']->getPrixM();
        }
        return $total;
    }

    public function removeAllItem()
    {
        $panier = $this->session->get('panier', []);
        if (!empty($panier)) {
            foreach ($panier as $id => $quantity) {
                unset($panier[$id]);
            }
        }
        $this->session->set('panier', $panier);
    }

    public function commender()
    {
        $user = $this->participantRepository->findOneByEmail($this->session->get('app_login_from_last_email'));
        $panier = $this->session->get('panier', []);
        $commande = new Commande();
        $commande->setUser($user);
        if (!empty($panier)) {
            foreach ($panier as $id => $quantity) {
                $commande->addMatierPo($this->matiereRepository->find($id));
            }
        }
        $user->addUser($commande);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($commande);
        $entityManager->flush();
    }

}

