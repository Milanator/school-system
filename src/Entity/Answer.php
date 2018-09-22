<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AnswerRepository")
 */
class Answer
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ExamQuestion", inversedBy="answers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $exam_question;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getExamQuestion(): ?ExamQuestion
    {
        return $this->exam_question;
    }

    public function setExamQuestion(?ExamQuestion $exam_question): self
    {
        $this->exam_question = $exam_question;

        return $this;
    }
}
