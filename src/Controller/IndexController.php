<?php

namespace App\Controller;

use App\Entity\Matiere;
use App\Form\MatiereType;
use App\Repository\MatiereRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/index")
 */
class IndexController extends AbstractController
{
    /**
     * @Route("/", name="app_index")
     * @IsGranted("ROLE_USER")
     */
    public function index(MatiereRepository $matiereRepository): Response
    {

        return $this->render('index/index.html.twig', [
            'controller_name' => 'IndexController',
            'matieres' => $matiereRepository->findAll(),

        ]);
    }

    /**
     * @Route("/new", name="matiere_new", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     */
    public function new(Request $request): Response
    {
        $matiere = new Matiere();
        $form = $this->createForm(MatiereType::class, $matiere);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($matiere);
            $entityManager->flush();

            return $this->redirectToRoute('app_index');
        }

        return $this->render('index/new.html.twig', [
            'matiere' => $matiere,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="index_matiere_show", methods={"GET"})
     */
    public function show(Matiere $matiere): Response
    {
        return $this->render('index/show.html.twig', [
            'matiere' => $matiere,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="index_matiere_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Matiere $matiere): Response
    {
        $form = $this->createForm(MatiereType::class, $matiere);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('app_index');
        }

        return $this->render('index/edit.html.twig', [
            'matiere' => $matiere,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="matiere1_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Matiere $matiere): Response
    {
        if ($this->isCsrfTokenValid('delete'.$matiere->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($matiere);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_index');
    }



}
