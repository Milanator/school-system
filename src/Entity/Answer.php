<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Question", inversedBy="answers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $question;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="boolean")
     */
    private $correct;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\QuestionResult", mappedBy="answer", orphanRemoval=true)
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

    public function getQuestion(): ?Question
    {
        return $this->question;
    }

    public function setQuestion(?Question $question): self
    {
        $this->question = $question;

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

    public function getCorrect(): ?bool
    {
        return $this->correct;
    }

    public function setCorrect(bool $correct): self
    {
        $this->correct = $correct;

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
            $questionResult->setAnswer($this);
        }

        return $this;
    }

    public function removeQuestionResult(QuestionResult $questionResult): self
    {
        if ($this->questionResults->contains($questionResult)) {
            $this->questionResults->removeElement($questionResult);
            // set the owning side to null (unless already changed)
            if ($questionResult->getAnswer() === $this) {
                $questionResult->setAnswer(null);
            }
        }

        return $this;
    }
}
