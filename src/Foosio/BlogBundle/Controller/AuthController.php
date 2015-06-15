<?php


namespace Foosio\BlogBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

// these import the "@Route" and "@Template" annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use OAuth2;

/**
 * Class AuthController
 * @package Foosio\BlogBundle\Controller
 * @Route("/authorize")
 */
class AuthController extends Controller {
    /**
     * @Route("/", name="auth")
     */
    public function authAction(Request $request)
    {
        $authorizeClient = $this->container->get('stark_industries_client.authorize_client');

        if (!$request->query->get('code')) {
            return new RedirectResponse($authorizeClient->getAuthenticationUrl());
        }
//        var_dump($request->query->get('code'));exit;
        $code = $request->query->get('code');
        $authorizeClient->getAccessToken($code);

        return new Response($authorizeClient->fetch('http://oauth-client.local/blog'));
    }
}