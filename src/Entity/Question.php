<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\QuestionRepository")
 */
class Question
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="question")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    protected $count_answers;

    /**
     * @ORM\Column(type="integer")
     */
    private $count_correct;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Answer", mappedBy="question", orphanRemoval=true)
     */
    private $answers;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="question")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Question", mappedBy="exams")
     */
    private $exams;

    public function __construct()
    {
        $this->answers = new ArrayCollection();
        $this->exams = new ArrayCollection();
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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

    public function getCountCorrect(): ?int
    {
        return $this->count_correct;
    }

    public function setCountCorrect(int $count_correct): self
    {
        $this->count_correct = $count_correct;

        return $this;
    }

    /**
     * @return Collection|Answer[]
     */
    public function getAnswers(): Collection
    {
        return $this->answers;
    }

    public function addAnswer(Answer $answer): self
    {
        if (!$this->answers->contains($answer)) {
            $this->answers[] = $answer;
            $answer->setQuestion($this);
        }

        return $this;
    }

    public function removeAnswer(Answer $answer): self
    {
        if ($this->answers->contains($answer)) {
            $this->answers->removeElement($answer);
            // set the owning side to null (unless already changed)
            if ($answer->getQuestion() === $this) {
                $answer->setQuestion(null);
            }
        }

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

    /**
     * @return Collection|Exam[]
     */
    public function getExams(): Collection {

        return $this->exams;
    }
    public function addExam(Exam $exam): self {

        if (!$this->exams->contains($exam)) {
            $this->exams[] = $exam;
            $exam->addTag($this);
        }

        return $this;
    }
    public function removeExam(Exam $exam): self {

        if ($this->exams->contains($exam)) {
            $this->exams->removeElement($exam);
            $exam->removeTag($this);
        }

        return $this;
    }
}
