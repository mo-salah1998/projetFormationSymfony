<?php

namespace App\Controller;

use App\Repository\MatiereRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(MatiereRepository $matiereRepository)
    {

        $Matiers=$matiereRepository->findAll();
        $data=[];
        foreach ($Matiers as $matier){
            $data[]= [
                'nomMatiere'=>$matier->getNomM(),
                'prix'=>$matier->getPrixM(),
                'image'=>$matier->getImgSrc(),
            ];
        }

        return new JsonResponse($data);
       // foreach ($datas as $id => $data){
        //$reponse->setData(json_encode(['$datas' => $data]));

       //foreach ($datas as $id => $data){
       //    //dd($data->getNomM());
       //    $reponse->setData(json_encode([
       //        '$id' => $data->getNomM(), $data->getPrixM(),$data->getImgSrc(),
       //    ]));

       //    //$reponse->setData("json_encode($id->prixMat");
       //    //$reponse->setData("json_encode($id->imgMat");


       // dd($reponse);



       // return $this->render('home.html.twig',[
        //    'matieres' => $matiereRepository->findAll(),
        //]);
    }
}
