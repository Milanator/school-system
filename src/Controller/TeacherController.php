<?php

namespace App\Controller;

use App\Entity\Answer;
use App\Entity\Category;
use App\Entity\Exam;
use App\Entity\ExamResult;
use App\Entity\Question;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TeacherController extends AbstractController {

    private function storingQuestions($data, $entityManager) {

        $data           = $data->request;
        $countAnswers   = $data->get('countAnswers');
        $countQuestions = $data->get('countQuestions');
        $userId         = $data->get('userId');
        $categoryId     = $data->get('categoryId');
        $user           = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($userId);
        $category       = $this->getDoctrine()
            ->getRepository(Category::class)
            ->find($categoryId);

        for ($i = 1; $i < $countQuestions; $i++) {

            $name         = $data->get('question' . $i);
            $correctCount = 0;

            // correct counter
            for ($j = 1; $j <= $countAnswers; $j++) {

                $correctName = 'correct' . $i . $j;
                if ($data->get($correctName) == 'on') {
                    $correctCount++;
                }
            }

            // create questions of exam
            $question = new Question();
            $question->setCategory($category);
            $question->setUser($user);
            $question->setName($name);
            $question->setCountAnswers($countAnswers);
            $question->setCountCorrect($correctCount);

            $entityManager->persist($question);

            // create answers of exam questions
            for ($j = 1; $j <= $countAnswers; $j++) {

                $correct     = $data->get('correct' . $i . $j) ? 1 : 0;
                $answerTitle = $data->get('answer' . $i . $j);

                $answer = new Answer();
                $answer->setQuestion($question);
                $answer->setName($answerTitle);
                $answer->setCorrect($correct);

                $entityManager->persist($answer);
            }
        }

        $entityManager->flush();

        return $category->getName();
    }

    public function index() {
        return $this->render('teacher/index.html.twig', [
            'controller_name' => 'TeacherController',
        ]);
    }

    public function createExam($category) {

        $category = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findOneBy([
                'name' => $category
            ]);

        $students = $this->getDoctrine()
            ->getRepository(User::class)
            ->findBy([
                'teacher' => 0
            ]);

        return $this->render('teacher/exams/createExam.html.twig', [
            'category' => $category,
            'students' => $students
        ]);
    }

    public function storeExam(Request $request) {

        $data        = Request::createFromGlobals()->request;
        $categoryId  = $data->get('categoryId');
        $userId      = $data->get('userId');
        $intendedFor = $data->get('students') == 'all' ? 0 : $data->get('students');
        $category    = $this->getDoctrine()
            ->getRepository(Category::class)
            ->find($categoryId);
        $user        = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($userId);

        $entityManager = $this->getDoctrine()->getManager();

        $exam = new Exam();
        $exam->setDescription($data->get('examDescription'));
        $exam->setActive($data->get('showExam') ? 1 : 0);
        $exam->setCategory($category);
        $exam->setCreator($user);
        $exam->setCountAnswers(0);
        $exam->setDone(0);
        $exam->setIntentedFor($intendedFor);
        $exam->setDate(new \DateTime());

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($exam);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return $this->redirectToRoute('exam', ['id' => $exam->getId()]);
    }

    public function deleteExam($id) {

        $entityManager = $this->getDoctrine()->getManager();
        $exam          = $this->getDoctrine()
            ->getRepository(Exam::class)
            ->find($id);

        $entityManager->remove($exam);
        $entityManager->flush();

        return $this->redirectToRoute('exams');
    }

    public function questionsList($id) {

        $exam = $this->getDoctrine()
            ->getRepository(Exam::class)
            ->find($id);

        return $this->render('teacher/questions/questionsList.html.twig', [
            'exam' => $exam
        ]);
    }

    public function createQuestions($category) {

        $category = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findOneBy([
                'name' => $category
            ]);

        return $this->render('teacher/questions/createQuestions.html.twig', [
            'category' => $category
        ]);
    }

    public function deleteQuestion($questionId) {

        $entityManager = $this->getDoctrine()->getManager();
        $question      = $this->getDoctrine()
            ->getRepository(Question::class)
            ->find($questionId);
        $categoryName  = $question->getCategory()->getName();

        $entityManager->remove($question);
        $entityManager->flush();

        return $this->redirectToRoute('createQuestions', ['category' => $categoryName]);
    }

    public function storeQuestions(Request $request) {

        $entityManager = $this->getDoctrine()->getManager();
        $data          = Request::createFromGlobals();

        $categoryName = $this->storingQuestions($data, $entityManager);

        return $this->redirectToRoute('createQuestions', ['category' => $categoryName]);
    }

    public function deleteExamQuestion($examId, $questionId) {

        $entityManager = $this->getDoctrine()->getManager();
        $question      = $this->getDoctrine()
            ->getRepository(Question::class)
            ->find($questionId);
        $exam          = $this->getDoctrine()
            ->getRepository(Exam::class)
            ->find($examId);

        $exam->removeQuestion($question);
        $entityManager->persist($exam);

        $entityManager->flush();

        return $this->redirectToRoute('questionsList', ['id' => $exam->getId()]);
    }

    public function selectExamQuestions($id) {

        $exam     = $this->getDoctrine()
            ->getRepository(Exam::class)
            ->find($id);
        $category = $this->getDoctrine()
            ->getRepository(Category::class)
            ->find($exam->getCategory()->getId());

        return $this->render('teacher/exams/selectExamQuestions.html.twig', [
            'exam'     => $exam,
            'category' => $category
        ]);
    }

    public function storeExamQuestions() {

        $data              = Request::createFromGlobals()->request;
        $entityManager     = $this->getDoctrine()->getManager();
        $examId            = $data->get('examId');
        $selectedQuestions = $data->get('selectedQuestions');
        $exam              = $this->getDoctrine()
            ->getRepository(Exam::class)
            ->find($examId);

        $exam->removeAllQuestions();

        foreach ($selectedQuestions as $questionId) {

            $question = $this->getDoctrine()
                ->getRepository(Question::class)
                ->find($questionId);

            $exam->addQuestion($question);
            $entityManager->persist($exam);
        }

        $entityManager->flush();

        return $this->redirectToRoute('selectExamQuestions', ['id' => $examId]);
    }

    public function allSubjects() {

        $categories = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findAll();

        return $this->render('student/subjects/index.html.twig', [
            'subjects' => $categories
        ]);
    }

    public function singleSubject($id) {

        $category = $this->getDoctrine()
            ->getRepository(Category::class)
            ->find($id);

        return $this->render('student/subjects/singleSubject.html.twig', [
            'subject' => $category
        ]);
    }

    public function updateSubject($id, Request $request) {

        $subject       = $this->getDoctrine()
            ->getRepository(Category::class)
            ->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $data          = Request::createFromGlobals()->request;

        $subject->setName($data->get('name'));
        $subject->setDescription($data->get('description'));

        $entityManager->persist($subject);
        $entityManager->flush();

        return $this->redirectToRoute('subject', [
            'id' => $id
        ]);
    }

    public function createSubject() {

        return $this->render('student/subjects/createSubject.html.twig');
    }

    public function storeSubject(Request $request) {

        $entityManager = $this->getDoctrine()->getManager();
        $data          = Request::createFromGlobals()->request;

        $subject = new Category();
        $subject->setName($data->get('name'));
        $subject->setDescription($data->get('description'));

        $entityManager->persist($subject);
        $entityManager->flush();

        return $this->redirectToRoute('subjects');
    }

    public function showExam($id) {

        $exam          = $this->getDoctrine()
            ->getRepository(Exam::class)
            ->find($id);
        $entityManager = $this->getDoctrine()->getManager();

        $exam->setActive($exam->getActive() == 1 ? 0 : 1);
        $entityManager->persist($exam);

        $entityManager->flush();

        return $this->redirectToRoute('exam', ['id' => $exam->getId()]);
    }

    public function studentsResults($id) {

        $exam          = $this->getDoctrine()
            ->getRepository(Exam::class)
            ->find($id);

        $examResults = $this->getDoctrine()
            ->getRepository(ExamResult::class)
            ->findBy([
                'exam' => $exam->getId()
            ]);


        return $this->render('common/exams/studentsResults.html.twig', [
            'exam' => $exam,
            'examResults' => $examResults
        ]);
    }
}
