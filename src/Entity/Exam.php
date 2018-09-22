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
     * @ORM\OneToMany(targetEntity="App\Entity\ExamQuestion", mappedBy="exam", orphanRemoval=true)
     */
    private $examQuestions;

    public function __construct()
    {
        $this->examQuestions = new ArrayCollection();
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

    /**
     * @return Collection|ExamQuestion[]
     */
    public function getExamQuestions(): Collection
    {
        return $this->examQuestions;
    }

    public function addExamQuestion(ExamQuestion $examQuestion): self
    {
        if (!$this->examQuestions->contains($examQuestion)) {
            $this->examQuestions[] = $examQuestion;
            $examQuestion->setExam($this);
        }

        return $this;
    }

    public function removeExamQuestion(ExamQuestion $examQuestion): self
    {
        if ($this->examQuestions->contains($examQuestion)) {
            $this->examQuestions->removeElement($examQuestion);
            // set the owning side to null (unless already changed)
            if ($examQuestion->getExam() === $this) {
                $examQuestion->setExam(null);
            }
        }

        return $this;
    }
}
