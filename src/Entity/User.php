<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface, \Serializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $teacher;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Exam", mappedBy="creator", orphanRemoval=true)
     */
    private $exams;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ExamQuestion", mappedBy="user", orphanRemoval=true)
     */
    private $examQuestions;

    public function __construct()
    {
        $this->exams = new ArrayCollection();
        $this->examQuestions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getTeacher(): ?bool
    {
        return $this->teacher;
    }

    public function setTeacher(?bool $teacher): self
    {
        $this->teacher = $teacher;

        return $this;
    }

    public function getSalt()
    {
        return null;
    }


    public function getRoles()
    {
        if( $this->teacher == 1 ){
            return array('ROLE_ADMIN');
        } else{
            return array('ROLE_USER');
        }
    }

    public function eraseCredentials()
    {
    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt
            ) = unserialize($serialized, array('allowed_classes' => false));
    }

    /**
     * @return Collection|Exam[]
     */
    public function getExams(): Collection
    {
        return $this->exams;
    }

    public function addExam(Exam $exam): self
    {
        if (!$this->exams->contains($exam)) {
            $this->exams[] = $exam;
            $exam->setCreator($this);
        }

        return $this;
    }

    public function removeExam(Exam $exam): self
    {
        if ($this->exams->contains($exam)) {
            $this->exams->removeElement($exam);
            // set the owning side to null (unless already changed)
            if ($exam->getCreator() === $this) {
                $exam->setCreator(null);
            }
        }

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
            $examQuestion->setUser($this);
        }

        return $this;
    }

    public function removeExamQuestion(ExamQuestion $examQuestion): self
    {
        if ($this->examQuestions->contains($examQuestion)) {
            $this->examQuestions->removeElement($examQuestion);
            // set the owning side to null (unless already changed)
            if ($examQuestion->getUser() === $this) {
                $examQuestion->setUser(null);
            }
        }

        return $this;
    }
}
