<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ExamResultRepository")
 */
class ExamResult
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="examResults")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Exam", inversedBy="examResults")
     * @ORM\JoinColumn(nullable=false)
     */
    private $exam;

    /**
     * @ORM\Column(type="float")
     */
    private $percentage;

    /**
     * @ORM\Column(type="integer")
     */
    private $correct;

    /**
     * @ORM\Column(type="integer")
     */
    private $incorrect;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\QuestionResult", mappedBy="exam_result")
     */
    private $questionResults;

    public function __construct()
    {
        $this->questionResults = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getExam(): ?Exam
    {
        return $this->exam;
    }

    public function setExam(?Exam $exam): self
    {
        $this->exam = $exam;

        return $this;
    }

    public function getPercentage(): ?int
    {
        return $this->percentage;
    }

    public function setPercentage(int $percentage): self
    {
        $this->percentage = $percentage;

        return $this;
    }

    public function getCorrect(): ?int
    {
        return $this->correct;
    }

    public function setCorrect(int $correct): self
    {
        $this->correct = $correct;

        return $this;
    }

    public function getIncorrect(): ?int
    {
        return $this->incorrect;
    }

    public function setIncorrect(int $incorrect): self
    {
        $this->incorrect = $incorrect;

        return $this;
    }

    /**
     * @return Collection|QuestionResult[]
     */
    public function getQuestionResults(): Collection
    {
        return $this->questionResults;
    }

    public function addQuestionResult(QuestionResult $questionResult): self
    {
        if (!$this->questionResults->contains($questionResult)) {
            $this->questionResults[] = $questionResult;
            $questionResult->setExamResult($this);
        }

        return $this;
    }

    public function removeQuestionResult(QuestionResult $questionResult): self
    {
        if ($this->questionResults->contains($questionResult)) {
            $this->questionResults->removeElement($questionResult);
            // set the owning side to null (unless already changed)
            if ($questionResult->getExamResult() === $this) {
                $questionResult->setExamResult(null);
            }
        }

        return $this;
    }
}
