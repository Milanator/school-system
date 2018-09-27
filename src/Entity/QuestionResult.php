<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\QuestionResultRepository")
 */
class QuestionResult
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Question", inversedBy="questionResults")
     * @ORM\JoinColumn(nullable=false)
     */
    private $question;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ExamResult", inversedBy="questionResults")
     * @ORM\JoinColumn(nullable=false)
     */
    private $exam_result;

    /**
     * @ORM\Column(type="boolean")
     */
    private $correct;

    /**
     * @ORM\Column(type="integer")
     */
    private $point;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Answer", inversedBy="questionResults")
     * @ORM\JoinColumn(nullable=false)
     */
    private $answer;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuestion(): ?Question
    {
        return $this->question;
    }

    public function setQuestion(?Question $question): self
    {
        $this->question = $question;

        return $this;
    }

    public function getExamResult(): ?ExamResult
    {
        return $this->exam_result;
    }

    public function setExamResult(?ExamResult $exam_result): self
    {
        $this->exam_result = $exam_result;

        return $this;
    }

    public function getCorrect(): ?bool
    {
        return $this->correct;
    }

    public function setCorrect(bool $correct): self
    {
        $this->correct = $correct;

        return $this;
    }

    public function getPoint(): ?int
    {
        return $this->point;
    }

    public function setPoint(int $point): self
    {
        $this->point = $point;

        return $this;
    }

    public function getAnswer(): ?Answer
    {
        return $this->answer;
    }

    public function setAnswer(?Answer $answer): self
    {
        $this->answer = $answer;

        return $this;
    }
}
