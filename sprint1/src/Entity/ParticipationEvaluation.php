<?php

namespace App\Entity;

use App\Repository\ParticipationEvaluationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ParticipationEvaluationRepository::class)
 */
class ParticipationEvaluation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $Code;

    /**
     * @ORM\Column(type="integer")
     */
    private $idP;

    /**
     * @ORM\Column(type="integer")
     */
    private $idE;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $Note;

    public function getIdE(): ?int
    {
        return $this->idE;
    }

    public function getIdP(): ?int
    {
        return $this->idP;
    }

    public function getCode(): ?int
    {
        return $this->Code;
    }

    public function setIdP(int $idP): self
    {
        $this->idP = $idP;

        return $this;
    }

    public function setIdE(int $idE): self
    {
        $this->idE = $idE;

        return $this;
    }

    public function setCode(int $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getNote(): ?int
    {
        return $this->Note;
    }

    public function setNote(?int $Note): self
    {
        $this->Note = $Note;

        return $this;
    }
}
