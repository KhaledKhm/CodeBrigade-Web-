<?php

namespace App\Entity;

use App\Repository\CVRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     *  @Assert\NotBlank(message="🔴 Veuillez Saisir Votre Nom ‼️")
     *   @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message="🔴 Votre Nom Ne Peut Pas Contenir Un Nombre  ‼️"
     * )
     */
    private $Nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="🔴 Veuillez Saisir Votre Prenom ‼️")
     *   @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message="🔴 Votre Prenom Ne Peut Pas Contenir Un Nombre  ‼️"
     * )
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="🔴 Veuillez choisir un fichier  ‼️")
     *
     */

    private $CvDoc;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom()
    {
        return $this->Nom;
    }

    public function setNom($Nom)
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function getPrenom()
    {
        return $this->prenom;
    }

    public function setPrenom( $prenom )
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getCvDoc()
    {
        return $this->CvDoc;
    }

    public function setCvDoc(  $CvDoc)
    {
        $this->CvDoc = $CvDoc;

        return $this;
    }
}
