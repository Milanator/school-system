<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ExamRepository")
 */
class Exam
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="exams")
     * @ORM\JoinColumn(nullable=false)
     */
    private $creator;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="exams")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="boolean")
     */
    private $active;

    /**
     * @ORM\Column(type="boolean")
     */
    private $done;

    /**
     * @ORM\Column(type="integer")
     */
    private $count_answers;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $intented_for;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Question", inversedBy="exams")
     */
    private $questions;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ExamResult", mappedBy="exam", orphanRemoval=true)
     */
    private $examResults;

    public function __construct()
    {
        $this->questions = new ArrayCollection();
        $this->examResults = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreator(): ?User
    {
        return $this->creator;
    }

    public function setCreator(?User $creator): self
    {
        $this->creator = $creator;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function getDone(): ?bool
    {
        return $this->done;
    }

    public function setDone(bool $done): self
    {
        $this->done = $done;

        return $this;
    }

    public function getCountAnswers(): ?int
    {
        return $this->count_answers;
    }

    public function setCountAnswers(int $count_answers): self
    {
        $this->count_answers = $count_answers;

        return $this;
    }

    public function getIntentedFor(): ?string
    {
        return $this->intented_for;
    }

    public function setIntentedFor(string $intented_for): self
    {
        $this->intented_for = $intented_for;

        return $this;
    }

    /**
     * @return Collection|Question[]
     */
    public function getQuestions(): Collection {

        return $this->questions;
    }

    public function addQuestion(Question $question): self {

        if (!$this->questions->contains($question)) {
            $this->questions[] = $question;
        }

        return $this;
    }

    public function removeQuestion(Question $question): self {

        if ($this->questions->contains($question)) {
            $this->questions->removeElement($question);
        }

        return $this;
    }

    public function removeAllQuestions() {

        foreach ( $this->questions as $question ){
            if ($this->questions->contains($question)) {
                $this->questions->removeElement($question);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ExamResult[]
     */
    public function getExamResults(): Collection
    {
        return $this->examResults;
    }

    public function addExamResult(ExamResult $examResult): self
    {
        if (!$this->examResults->contains($examResult)) {
            $this->examResults[] = $examResult;
            $examResult->setExam($this);
        }

        return $this;
    }

    public function removeExamResult(ExamResult $examResult): self
    {
        if ($this->examResults->contains($examResult)) {
            $this->examResults->removeElement($examResult);
            // set the owning side to null (unless already changed)
            if ($examResult->getExam() === $this) {
                $examResult->setExam(null);
            }
        }

        return $this;
    }
}
