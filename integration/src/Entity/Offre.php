<?php

namespace App\Entity;

use App\Repository\OffreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Integer;

/**
 * @ORM\Entity(repositoryClass=OffreRepository::class)
 */
class Offre
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
    private $Libelle;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Description;

    /**
     * @ORM\Column(type="string")
     */
    private $Salaire;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Disponabilite;

    /**
     * @ORM\Column(type="string")
     */
    private $DateLimite;

    /**
     * @ORM\ManyToMany(targetEntity=Utilisateur::class, inversedBy="offres")
     */
    private $utilisateurs;
    /**
     * @ORM\ManyToMany(targetEntity=Utilisateur::class, inversedBy="favoris")
     * @ORM\JoinTable(name="Utilisateur_favoris")
     */
    private $favoris;
    public function __construct()
    {
        $this->favoris = new ArrayCollection();
    }
    /**
     * @return Collection|Utilisateur[]
     */
    public function getFavoris(): Collection
    {
        return $this->favoris;
    }

    public function addFavori(Utilisateur $favori): self
    {
        if (!$this->favoris->contains($favori)) {
            $this->favoris[] = $favori;
        }

        return $this;
    }

    public function removeFavori(Utilisateur $favori): self
    {
        $this->favoris->removeElement($favori);

        return $this;
    }

//    /**
//     * @ORM\ManyToMany(targetEntity=Postulant::class, inversedBy="favoris")
//     * @ORM\JoinTable(name="postulant_favoris")
////     */
//    private $favoris;
//
//    public function __construct()
//    {
//        $this->favoris = new ArrayCollection();
//    }
    public function getUtilisateurs(): Collection
    {
        return $this->utilisateurs;
    }
    public function addUtilisateur(Utilisateur $utilisateur): self
    {
        if (!$this->utilisateurs->contains($utilisateur)) {
            $this->utilisateurs[] = $utilisateur;
        }

        return $this;
    }

    public function removeUtilisateur(Utilisateur $utilisateur): self
    {
        $this->utilisateurs->removeElement($utilisateur);

        return $this;
    }


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

    public function getSalaire(): ?string
    {
        return $this->Salaire;
    }

    public function setSalaire(string $Salaire): self
    {
        $this->Salaire = $Salaire;

        return $this;
    }

    public function getDisponabilite(): ?string
    {
        return $this->Disponabilite;
    }

    public function setDisponabilite(string $Disponabilite): self
    {
        $this->Disponabilite = $Disponabilite;

        return $this;
    }

    public function getDateLimite(): ?string
    {
        return $this->DateLimite;
    }

    public function setDateLimite(string $DateLimite): self
    {
        $this->DateLimite = $DateLimite;

        return $this;
    }

//    /**
//     * @return Collection|Postulant[]
//     */
//    public function getPostulants(): Collection
//    {
//        return $this->postulants;
//    }
//
//    public function addPostulant(Postulant $postulant): self
//    {
//        if (!$this->postulants->contains($postulant)) {
//            $this->postulants[] = $postulant;
//        }
//
//        return $this;
//    }
//
//    public function removePostulant(Postulant $postulant): self
//    {
//        $this->postulants->removeElement($postulant);
//
//        return $this;
//    }
//
//    /**
//     * @return Collection|Postulant[]
//     */
//    public function getFavoris(): Collection
//    {
//        return $this->favoris;
//    }
//
//    public function addFavori(Postulant $favori): self
//    {
//        if (!$this->favoris->contains($favori)) {
//            $this->favoris[] = $favori;
//        }
//
//        return $this;
//    }
//
//    public function removeFavori(Postulant $favori): self
//    {
//        $this->favoris->removeElement($favori);
//
//        return $this;
//    }

}
