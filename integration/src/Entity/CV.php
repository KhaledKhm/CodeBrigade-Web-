<?php

namespace App\Entity;

use App\Repository\CVRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CVRepository::class)
 */
class CV
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
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $cvdoc;

    /**
     * @ORM\Column(type="integer")
     */
    private $idutli;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getCvdoc(): ?string
    {
        return $this->cvdoc;
    }

    public function setCvdoc(string $cvdoc): self
    {
        $this->cvdoc = $cvdoc;

        return $this;
    }

    public function getIdutli(): ?int
    {
        return $this->idutli;
    }

    public function setIdutli(int $idutli): self
    {
        $this->idutli = $idutli;

        return $this;
    }
}
