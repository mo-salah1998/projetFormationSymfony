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
 * @Route("/admin/index")
 * @IsGranted("ROLE_ADMIN")
 */
class IndexController extends AbstractController
{
    /**
     * @Route("/", name="app_index")
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
     *
     */
    public function new(Request $request): Response
    {
        $matiere = new Matiere();
        $form = $this->createForm(MatiereType::class, $matiere);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //requperation des images transmise

            $image = $form->get('imgSrc')->getData();

            $fichier = md5(uniqid()) . '.' . $image->guessExtension();



            $image->move(
                $this->getParameter('images_directory'),
                $fichier

            );

            $matiere->setImgSrc($fichier);



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
     * @param Matiere $matiere
     * @return Response
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
           // dd($images = $form->get('imgSrc')->getData());
            if(($form->get('imgSrc')->getData())!=null){
                //on recupère les images transmisse
                $images = $form->get('imgSrc')->getData();
                $fichier = md5(uniqid()) . '.' . $images->guessExtension();
                $images->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );
                $matiere ->setImgSrc($fichier);
            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('app_index');
        }

        return $this->render('index/edit.html.twig', [
            'matiere' => $matiere,
            'form' => $form->createView(),
        ]);
    }




    /**
     * @Route("/delete/{id}", name="matiere1_delete", methods={"DELETE"})
     * @param Request $request
     * @param Matiere $matiere
     * @return Response
     */
    public function delete(Request $request, Matiere $matiere): Response
    {
        if ($this->isCsrfTokenValid('delete' . $matiere->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            //TODO
            //recuperation de l'image a supprimer
            // $image = $matiere->getImgSrc();

            # dd($this->getParameter('images_directory')."/". $image);

           //  unlink( $this->getParameter('images_directory')."/". $image);


            $entityManager->remove($matiere);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_index');
    }




}
