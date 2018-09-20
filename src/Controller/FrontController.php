<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class FrontController extends AbstractController
{

    public function index()
    {
        return $this->render('front/index.html.twig');
    }

    public function login() {

        $user = new User();
        $user->setEmail('Write your email');
        $user->setPassword('Write your password');

        $form = $this->createFormBuilder($user)
            ->add('email', TextType::class)
            ->add('password', TextType::class)
            ->add('save', SubmitType::class, array('label' => 'Login'))
            ->getForm();

        return $this->render('front/login.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
