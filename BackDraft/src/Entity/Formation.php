<?php

namespace App\Entity;

use App\Repository\FormationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FormationRepository::class)
 */
class Formation
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
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbrPatricipant;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateDebutFor;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateFinFor;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getNbrPatricipant(): ?int
    {
        return $this->nbrPatricipant;
    }

    public function setNbrPatricipant(int $nbrPatricipant): self
    {
        $this->nbrPatricipant = $nbrPatricipant;

        return $this;
    }

    public function getDateDebutFor(): ?\DateTimeInterface
    {
        return $this->dateDebutFor;
    }

    public function setDateDebutFor(\DateTimeInterface $dateDebutFor): self
    {
        $this->dateDebutFor = $dateDebutFor;

        return $this;
    }

    public function getDateFinFor(): ?\DateTimeInterface
    {
        return $this->dateFinFor;
    }

    public function setDateFinFor(\DateTimeInterface $dateFinFor): self
    {
        $this->dateFinFor = $dateFinFor;

        return $this;
    }
}
