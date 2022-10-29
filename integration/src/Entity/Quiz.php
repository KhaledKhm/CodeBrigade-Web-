<?php

namespace App\Entity;

use App\Repository\QuizRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=QuizRepository::class)
 */
class Quiz
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Question;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Choix1;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Choix2;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Choix3;

    /**
     * @ORM\Column(type="integer")
     */
    private $Reponse;

    /**
     * @ORM\Column(type="integer")
     */
    private $idEvaluation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuestion(): ?string
    {
        return $this->Question;
    }

    public function setQuestion(string $Question): self
    {
        $this->Question = $Question;

        return $this;
    }

    public function getChoix1(): ?string
    {
        return $this->Choix1;
    }

    public function setChoix1(string $Choix1): self
    {
        $this->Choix1 = $Choix1;

        return $this;
    }

    public function getChoix2(): ?string
    {
        return $this->Choix2;
    }

    public function setChoix2(string $Choix2): self
    {
        $this->Choix2 = $Choix2;

        return $this;
    }

    public function getChoix3(): ?string
    {
        return $this->Choix3;
    }

    public function setChoix3(string $Choix3): self
    {
        $this->Choix3 = $Choix3;

        return $this;
    }

    public function getReponse(): ?int
    {
        return $this->Reponse;
    }

    public function setReponse(int $Reponse): self
    {
        $this->Reponse = $Reponse;

        return $this;
    }

    public function getIdEvaluation(): ?int
    {
        return $this->idEvaluation;
    }

    public function setIdEvaluation(int $idEvaluation): self
    {
        $this->idEvaluation = $idEvaluation;

        return $this;
    }
}
