<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Form\FormTypeInterface;
use Scheb\TwoFactorBundle\Model\Google\TwoFactorInterface;
use Symfony\Component\Validator\Constraints\Date;

/**
 * @ORM\Entity(repositoryClass=UtilisateurRepository::class)
 * @UniqueEntity("email")
 */

class Utilisateur implements UserInterface, TwoFactorInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @ORM\Column(type="string", length=128, nullable=true)
    * @Assert\NotBlank(
     * )
     */
    private $password;



    /**
     * @Assert\EqualTo(propertyPath="password",message="Password not matching")
     */
    public $confirmPassword;


    /**
     * @ORM\Column(type="string", length=16, nullable=true)
     * @Assert\NotBlank(
     * )
     */
    private $accountStatus;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\NotBlank(
     * )
     */
    private $cinPersonne;

    /**
     * @ORM\Column(type="string", length=16, nullable=true)
     * @Assert\NotBlank(
     * )
     */
    private $immatriculeEntreprise;

    /**
     * @ORM\Column(type="string", length=16, nullable=true)
     * @Assert\NotBlank(
     * )
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "Your first name must be at least {{ limit }} characters long",
     *      maxMessage = "Your first name cannot be longer than {{ limit }} characters"
     * )
     */
    private $nomPersonne;

    /**
     * @ORM\Column(type="string", length=16, nullable=true)
     * @Assert\NotBlank(
     * )
     * @Assert\Length(
     *      min = 3,
     *      max = 16,
     *      minMessage = "Your first name must be at least {{ min }} characters long",
     *      maxMessage = "Your first name cannot be longer than {{ max }} characters"
     * )
     */
    private $prenomPersonne;

    /**
     * @ORM\Column(type="string", length=16, nullable=true)
     * @Assert\NotBlank(
     * )@Assert\Length(
     *      min = 3,
     *      max = 16,
     *      minMessage = "Your first name must be at least {{ min }} characters long",
     *      maxMessage = "Your first name cannot be longer than {{ max }} characters"
     * )
     */
    private $libelleEntreprise;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     * @Assert\NotBlank(
     * )
     */
    private $sexePersonne;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateNaisPersonne;

    /**
     * @ORM\Column(type="string", length=16, nullable=true)
     * @Assert\NotBlank(
     * )
     */
    private $etatSocialePersonne;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\NotBlank(
     * )
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=128, nullable=true)
     * @Assert\NotBlank(
     * )
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=64, nullable=true, unique=true)
     * @Assert\NotBlank(
     * )
     * @Assert\Email(
     *     message = "The email '{{ $email }}' is not a valid email."
     * )

     */
    private $email;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     * @Assert\NotBlank(
     * )
     * @Assert\Url(
     *    message = "The url '{{ $siteweb }}' is not a valid url",
     * )

     */
    private $siteweb;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     * @Assert\NotBlank(
     * )
     */
    private $domainePersonne;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     * @Assert\NotBlank(
     * )
     */
    private $secteurEntreprise;

    /**
     * @ORM\Column(type="string", length=256, nullable=true)
     */
    private $role;

    /**
     * @ORM\Column(name="googleAuthenticatorSecret", type="string", nullable=true)
     */
    private $googleAuthenticatorSecret;


    public function getId(): ?int
    {
        return $this->id;
    }


    /**
     * @see UserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRole(): ?string
    {
        return $this->role;
      //  $role[]= 'ROLE_USER';
    }

    public function setRole(?string $role): self
    {
        $this->role = $role;

        return $this;
    }
    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "auto" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getAccountStatus(): ?string
    {
        return $this->accountStatus;
    }

    public function setAccountStatus(?string $accountStatus): self
    {
        $this->accountStatus = $accountStatus;

        return $this;
    }

    public function getCinPersonne(): ?int
    {
        return $this->cinPersonne;
    }

    public function setCinPersonne(?int $cinPersonne): self
    {
        $this->cinPersonne = $cinPersonne;

        return $this;
    }

    public function getImmatriculeEntreprise(): ?string
    {
        return $this->immatriculeEntreprise;
    }

    public function setImmatriculeEntreprise(?string $immatriculeEntreprise): self
    {
        $this->immatriculeEntreprise = $immatriculeEntreprise;

        return $this;
    }

    public function getNomPersonne(): ?string
    {
        return $this->nomPersonne;
    }

    public function setNomPersonne(?string $nomPersonne): self
    {
        $this->nomPersonne = $nomPersonne;

        return $this;
    }

    public function getPrenomPersonne(): ?string
    {
        return $this->prenomPersonne;
    }

    public function setPrenomPersonne(?string $prenomPersonne): self
    {
        $this->prenomPersonne = $prenomPersonne;

        return $this;
    }

    public function getLibelleEntreprise(): ?string
    {
        return $this->libelleEntreprise;
    }

    public function setLibelleEntreprise(?string $libelleEntreprise): self
    {
        $this->libelleEntreprise = $libelleEntreprise;

        return $this;
    }

    public function getSexePersonne(): ?string
    {
        return $this->sexePersonne;
    }

    public function setSexePersonne(?string $sexePersonne): self
    {
        $this->sexePersonne = $sexePersonne;

        return $this;
    }

    public function getDateNaisPersonne(): ?\DateTimeInterface
    {
        return $this->dateNaisPersonne;
    }

    public function setDateNaisPersonne(?\DateTimeInterface $dateNaisPersonne): self
    {
        $this->dateNaisPersonne = $dateNaisPersonne;

        return $this;
    }

    public function getEtatSocialePersonne(): ?string
    {
        return $this->etatSocialePersonne;
    }

    public function setEtatSocialePersonne(?string $etatSocialePersonne): self
    {
        $this->etatSocialePersonne = $etatSocialePersonne;

        return $this;
    }

    public function getTelephone(): ?int
    {
        return $this->telephone;
    }

    public function setTelephone(?int $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getSiteweb(): ?string
    {
        return $this->siteweb;
    }

    public function setSiteweb(?string $siteweb): self
    {
        $this->siteweb = $siteweb;

        return $this;
    }

    public function getDomainePersonne(): ?string
    {
        return $this->domainePersonne;
    }

    public function setDomainePersonne(?string $domainePersonne): self
    {
        $this->domainePersonne = $domainePersonne;

        return $this;
    }

    public function getSecteurEntreprise(): ?string
    {
        return $this->secteurEntreprise;
    }

    public function setSecteurEntreprise(?string $secteurEntreprise): self
    {
        $this->secteurEntreprise = $secteurEntreprise;

        return $this;
    }


    public function getRoles()
    {
        return [$this->getRole()];
    }


    public function getUsername()
    {
        return $this->getEmail();
    }

    public function isGoogleAuthenticatorEnabled(): bool
    {
        return $this->googleAuthenticatorSecret ? true : false;
    }

    public function getGoogleAuthenticatorUsername(): string
    {
        return $this->email;
    }

    public function getGoogleAuthenticatorSecret(): ?string
    {
        return $this->googleAuthenticatorSecret;
    }

    public function setGoogleAuthenticatorSecret(?string $googleAuthenticatorSecret): void
    {
        $this->googleAuthenticatorSecret = $googleAuthenticatorSecret;
    }
}
