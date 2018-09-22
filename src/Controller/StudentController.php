<?php

namespace App\Controller;

use App\Entity\Exam;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
}
