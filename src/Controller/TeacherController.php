<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Exam;
use App\Entity\ExamQuestion;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TeacherController extends AbstractController
{

    /**
     * @Route("/teacher", name="teacher")
     */
    public function index()
    {
        return $this->render('teacher/index.html.twig', [
            'controller_name' => 'TeacherController',
        ]);
    }

    public function createExam() {

        $categories = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findAll();

        $students = $this->getDoctrine()
            ->getRepository(User::class)
            ->findBy([
                'teacher' => 0
            ]);

        return $this->render('teacher/exams/createExam.html.twig', [
            'categories' => $categories,
            'students' => $students
        ]);
    }

    public function storeExam(Request $request) {

        $data = Request::createFromGlobals()->request;
        $categoryId = $data->get('category');
        $userId = $data->get('userId');
        $category = $this->getDoctrine()
            ->getRepository(Category::class)
            ->find($categoryId);
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($userId);

        $entityManager = $this->getDoctrine()->getManager();

        $exam = new Exam();
        $exam->setDescription($data->get('examDescription'));
        $exam->setActive($data->get('showExam') ? 1 : 0);
        $exam->setCategory($category);
        $exam->setCreator($user);
        $exam->setDate(new \DateTime());

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($exam);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return $this->redirectToRoute('exam', [ 'id' => $exam->getId()]);
    }

    public function createQuestions($id) {

        $exam = $this->getDoctrine()
            ->getRepository(Exam::class)
            ->find($id);

        return $this->render('teacher/exams/createQuestions.html.twig',[
            'exam' => $exam
        ]);
    }

    public function storeQuestions(Request $request) {

        $entityManager = $this->getDoctrine()->getManager();
        $data = Request::createFromGlobals();

        $this->storingQuestions( $data, $entityManager );

        echo "<pre>";
        var_dump($data, $data->get('question1'));
        echo "</pre>";
        die( 'stop' );

        //return $this->redirectToRoute('singleExam', ['id'=>$exam->getId()]);
    }

    private function storingQuestions( $data, $entityManager ){

        $data = $data->request;
        $countAnswers = $data->get('countAnswers');
        $countQuestions = $data->get('countQuestions');
        $userId = $data->get('userId');
        $examId = $data->get('examId');
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($userId);
        $exam = $this->getDoctrine()
            ->getRepository(Exam::class)
            ->find($examId);

        for( $i = 1; $i < $countQuestions; $i++ ){

            $name = $data->get('question'.$i);
            $correctCount = 0;

            for ( $j = 1; $j < $countAnswers; $j++ ){

                $correctName = 'correct'.$i.$j;

                if( $data->get($correctName) == 'on' ){
                    $correctCount++;
                }
            }

            $question = new ExamQuestion();
            $question->setExam($exam);
            $question->setUser($user);
            $question->setName($name);
            $question->setCountAnswers($countAnswers);
            $question->setCountCorrect($correctCount);

            $entityManager->persist($question);
        }

        $entityManager->flush();
    }
}
