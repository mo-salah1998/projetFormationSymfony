<?php

namespace App\Security ;

use App\Controller\SecurityController;
use App\Repository\ParticipantRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\PassportInterface;

class LoginFormAuthenticator extends AbstractAuthenticator
{
    private $participant ;
    private $urlGenerator;


    public function __construct(ParticipantRepository $participant,UrlGeneratorInterface $urlGenerator)
    {
        $this->participant = $participant;
        $this->urlGenerator = $urlGenerator ;
    }

    public function supports(Request $request): ?bool
    {
        return $request->attributes->get('_route') ==='app_login'
            && $request->isMethod('POST');
    }

    public function authenticate(Request $request): PassportInterface
    {
        //dd($request->request->get('signin-email'));
        // find a user based on an "email" form field
        $user = $this->participant->findOneByEmail($request->request->get('signin-email'));

        $request->getSession()->set(SecurityController::Last_Email,
                                        $request->request->get('signin-email')
                                    );

        //dd($user);
        if (!$user) {
            throw new CustomUserMessageAuthenticationException('invalid credentials');
        }

        return new Passport($user
            , new PasswordCredentials($request->request->get('signin-password')), [
            new CsrfTokenBadge('Login_form', $request->request->get('csrf_token'))
            ]
        );
    }



    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return new RedirectResponse($this->urlGenerator->generate('app_index'));
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        $request->getSession()->getFlashbag()->add('error', 'Invalide credentials!');
        return new RedirectResponse($this->urlGenerator->generate('app_login'));
    }
}