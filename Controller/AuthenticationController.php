<?php
namespace CodeColliders\BasicUserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Contracts\Service\ServiceSubscriberInterface;

class AuthenticationController extends AbstractController
{
    private $authenticationUtils;
    private $branding;
    private $userIdentifier;

    /**
     * AuthenticationController constructor.
     * @param AuthenticationUtils $authenticationUtils
     */
    public function __construct(AuthenticationUtils $authenticationUtils, $branding, $userIdentifier)
    {
        $this->authenticationUtils = $authenticationUtils;
        $this->branding = $branding;
        $this->userIdentifier = $userIdentifier;
    }

    public function logout()
    {
        throw new \Exception('Don\'t forget to activate logout in security.yaml');
    }


    /**
     * @return Response
     */
    public function login(): Response
    {
        // get the login error if there is one
        $error = $this->authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $this->authenticationUtils->getLastUsername();

        return $this->render('@CodeCollidersBasicUser/login.html.twig', ['last_username' => $lastUsername, 'error' => $error, 'branding' => $this->branding, 'user_identifier' => $this->userIdentifier]);
    }
}
