<?php

namespace App\Controller;

use App\Form\UserRegistrationFormType;
use App\Repository\ParticipantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    public const Last_Email = 'app_login_from_last_email';
    private $repository ;
    public function __construct(ParticipantRepository $repository)
    {
        $this->repository = $repository ;
    }

    /**
     * @Route("/user/add", name="user",methods={"POST"})
     * @param Request $request
     * @return Response
     */
    public function Add(Request $request): Response
    {
        // recuperation des donner json ;
        $data=json_decode($request->getContent(),$assoc=true);
        $firstName=$data['firstName'];
        $lastName=$data['lastName'];
        $email=$data['email'];
        $nomcour=$data['nomcour'];
        $password=$data['password'];



        if(empty($firstName)||empty($lastName)||empty($email)){
            throw new NotFoundHttpException($message='parametres please');
        }

        $this->repository->saveUser($firstName,$lastName,$email,$nomcour,$password) ;
        return new Response($content=' User created ! ');


    }

    /**
     * @Route("/register", name="app_register", methods={"GET","POST"})
     */
    public function register(): Response
    {
        $form = $this->createForm(UserRegistrationFormType::class);
        return $this->render('security/register.html.twig', [
            'controller_name' => 'SecurityController',
            'registrationForm'=> $form->createView()
        ]);
    }

    /**
     * @Route("/login", name="app_login", methods={"GET","POST"})
     */
    public function login(): Response
    {
        return $this->render('security/index.html.twig', [
            'controller_name' => 'SecurityController',
        ]);
    }
    /**
     * @Route("/logout", name="app_logout", methods={"GET"})
     */
    public function logout(): Response
    {
        return $this->render('security/index.html.twig', [
            'controller_name' => 'SecurityController',
        ]);
    }
}
