<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    public function login(Request $request, AuthenticationUtils $utils)
    {
        $error = $utils->getLastAuthenticationError();

        $session = $request->getSession();

        $session->invalidate(); //here we can now clear the session.

        return $this->render('login.html.twig', [
            'error' => $error,
        ]);
    }
}
