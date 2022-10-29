<?php

namespace App\Entity;

use App\Repository\EntretienRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EntretienRepository::class)
 */
class Entretien
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $Libelle;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $Description;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $Dateentretien;

    /**
     * @ORM\Column(type="integer")
     */
    private $Idevaluation;

    /**
     * @ORM\Column(type="integer",nullable=true)
     */
    private $idParticipant;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->Libelle;
    }

    public function setLibelle(string $Libelle): self
    {
        $this->Libelle = $Libelle;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    public function getDateentretien(): ?string
    {
        return $this->Dateentretien;
    }

    public function setDateentretien(string $Dateentretien): self
    {
        $this->Dateentretien = $Dateentretien;

        return $this;
    }

    public function getIdEvaluation(): ?int
    {
        return $this->Idevaluation;
    }

    public function setIdEvaluation(int $Idevaluation): self
    {
        $this->Idevaluation = $Idevaluation;

        return $this;
    }

    public function getIdParticipant(): ?int
    {
        return $this->idParticipant;
    }

    public function setIdParticipant(int $idParticipant): self
    {
        $this->idParticipant = $idParticipant;

        return $this;
    }
}
