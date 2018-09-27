<?php

namespace App\Controller;

use App\Entity\Category;
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

    public function index() {

        if( ! $this->getUser() ){
            return $this->redirectToRoute('login');
        }

        $user = $this->getUser();

        if( $user->getTeacher() == 1 ){
            return $this->redirectToRoute('teacher');
        } else{
            return $this->redirectToRoute('student');
        }
    }

    public function subjectsToHeader() {

        $subjects = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findAll();

        return $this->render('partials/header.html.twig',[
                'subjects' => $subjects
            ]);
    }
}
