<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Exam;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class StudentController extends AbstractController
{
    /**
     * @Route("/student", name="student")
     */
    public function index()
    {
        return $this->render('student/index.html.twig');
    }

    public function allExams() {

        $exams = $this->getDoctrine()
            ->getRepository(Exam::class)
            ->findAll();

        return $this->render('student/exams/index.html.twig',[
            'exams' => $exams
        ]);
    }

    public function singleExam($id) {

        $exam = $this->getDoctrine()
            ->getRepository(Exam::class)
            ->find($id);

        return $this->render('student/exams/singleExam.html.twig',[
            'exam' => $exam
        ]);
    }

    public function allSubjects() {

        $categories = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findAll();

        return $this->render('student/subjects/index.html.twig',[
            'subjects' => $categories
        ]);
    }

    public function singleSubject($id) {

        $category = $this->getDoctrine()
            ->getRepository(Category::class)
            ->find($id);

        return $this->render('student/subjects/singleSubject.html.twig',[
            'subject' => $category
        ]);
    }

    public function storeSubject($id, Request $request) {

        $subject = $this->getDoctrine()
            ->getRepository(Category::class)
            ->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $data = Request::createFromGlobals()->request;

        $subject->setName($data->get('name'));
        $subject->setDescription($data->get('description'));

        $entityManager->persist($subject);
        $entityManager->flush();

        return $this->redirectToRoute('subject',[
            'id' => $id
        ]);
    }
}
