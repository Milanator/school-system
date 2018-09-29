<?php

namespace App\Controller;

use App\Entity\Exam;
use App\Entity\ExamResult;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommonController extends AbstractController
{

    private function checkAddressee($exam, $userId){

        if( ! $exam->getActive() ){
            return false;
        }
        if( $exam->getIntentedFor() != 0 && $exam->getIntentedFor() != $userId ){
            return false;
        }
        return true;
    }

    public function allExams() {

        $user = $this->getUser();
        $userId = $user->getId();

        if( $user->getTeacher() == 1 ) {

            $exams = $this->getDoctrine()
                ->getRepository(Exam::class)
                ->findAll();
        } else{

            $exams = $this->getDoctrine()
                ->getRepository(Exam::class)
                ->findAllStudentExams($userId);
        }

        return $this->render('common/exams/allExams.html.twig',[
            'exams' => $exams
        ]);
    }

    public function singleExam($id) {

        $exam = $this->getDoctrine()
            ->getRepository(Exam::class)
            ->find($id);
        $examIsDone = $this->getDoctrine()
            ->getRepository(ExamResult::class)
            ->findBy([
                'exam' => $exam->getId(),
                'user' => $this->getUser()->getId()
            ]);

        return $this->render('common/exams/singleExam.html.twig',[
            'exam' => $exam,
            'examIsDone' => $examIsDone ? true : false
        ]);
    }

    public function checkResult($examId, $userId) {

        $exam = $this->getDoctrine()
            ->getRepository(Exam::class)
            ->find($examId);
        $studentsExam = $this->getDoctrine()
            ->getRepository(ExamResult::class)
            ->findOneBy([
                'exam' => $exam->getId(),
                'user' => $userId
            ]);

        if( ! $studentsExam || ($userId != $this->getUser()->getId() && $this->getUser()->getTeacher() != 1 ) ){
            return new Response('Didnt fill exam. ', 404);
        }

        return $this->render('common/exams/viewResults.html.twig', [
            'exam' => $exam,
            'studentsExam' => $studentsExam
        ]);
    }

}
