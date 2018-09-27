<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Exam;
use App\Entity\ExamResult;
use App\Entity\QuestionResult;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StudentController extends AbstractController
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

    public function index()
    {
        return $this->render('student/index.html.twig');
    }

    public function fillExam($userId, $examId) {

        $exam = $this->getDoctrine()
            ->getRepository(Exam::class)
            ->find($examId);
        $examIsDone = $this->getDoctrine()
            ->getRepository(ExamResult::class)
            ->find($examId);

        if( ! $this->checkAddressee($exam, $userId) || $examIsDone ){
            return new Response('You do not have permission. ', 500);
        }

        return $this->render('student/exams/fillExam.html.twig', [
            'exam' => $exam
        ]);
    }

    public function storeExamResults($examId) {

        $entityManager = $this->getDoctrine()->getManager();
        $data = Request::createFromGlobals()->request;
        $exam = $this->getDoctrine()
            ->getRepository(Exam::class)
            ->find($examId);
        $points = 0;
        $user = $this->getUser();
        $maxPoits = count($exam->getQuestions());
        $examIsDone = $this->getDoctrine()
            ->getRepository(ExamResult::class)
            ->find($examId);

        if( $examIsDone ){
            return new Response('You do not have permission. ', 500);
        }

        $examResult = new ExamResult();
        $examResult->setUser($user);
        $examResult->setExam($exam);
        $examResult->setIncorrect(0);
        $examResult->setCorrect(0);
        $examResult->setPercentage(0);

        $entityManager->persist($examResult);

        foreach ( $exam->getQuestions() as $question ){

            $questionId = $question->getId();
            $studentAnswerId = $data->get('question'.$questionId);

            if( !$studentAnswerId ){
                continue;
            }

            foreach ($question->getAnswers() as $answer){

                if( $studentAnswerId != $answer->getId() ){
                    continue;
                }

                $correct = false;

                if($answer->getCorrect()){
                    $correct = true;
                    $points++;
                }

                $questionResult = new QuestionResult();
                $questionResult->setCorrect($correct);
                $questionResult->setQuestion($question);
                $questionResult->setExamResult($examResult);
                $questionResult->setPoint($correct);
                $questionResult->setAnswer($answer);

                $entityManager->persist($questionResult);
                break;

            }
        }

        $percentage = ($points != 0) ? ($points/$maxPoits)*100 : 0;

        $examResult->setCorrect($points);
        $examResult->setIncorrect($maxPoits-$points);
        $examResult->setPercentage($percentage);

        $entityManager->persist($examResult);

        $entityManager->flush();

        return $this->redirectToRoute('exam', ['id' => $examId]);
    }

    public function checkResult($examId) {

    }

}
