<?php

namespace App\Entity;

use App\Repository\FormationRepository;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;




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
     * @Assert\NotBlank
     */
    private $Libelle;

    /**
     * @ORM\Column(type="string", length=255)
     *
     */
    private $Description;

    /**
     * @ORM\Column(type="datetime")
     *
     */
    private $DateFormation;

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

    public function getDateFormation() :?\DateTimeInterface
    {
        return $this->DateFormation;
    }

    public function setDateFormation(\DateTimeInterface $DateFormation)
    {
        $this->DateFormation = $DateFormation;

        return $this;
    }
}
