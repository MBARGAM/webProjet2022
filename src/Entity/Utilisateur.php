<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UtilisateurRepository::class)
 */
class Utilisateur implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $adresseNo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $adresseRue;

    /**
     * @ORM\Column(type="date")
     */
    private $dateInscription;

    /**
     * @ORM\Column(type="boolean")
     */
    private $visible;

    /**
     * @ORM\Column(type="boolean")
     */
    private $inscriptConf;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbreEssai;

    /**
     * @ORM\OneToOne(targetEntity=Prestataire::class, inversedBy="utilisateur", cascade={"persist", "remove"})
     */
    private $prestataire;

    /**
     * @ORM\OneToOne(targetEntity=Internaute::class, inversedBy="utilisateur", cascade={"persist", "remove"})
     */
    private $internaute;

    /**
     * @ORM\ManyToOne(targetEntity=Commune::class, inversedBy="utilisateur")
     */
    private $commune;

    /**
     * @ORM\ManyToOne(targetEntity=Localite::class, inversedBy="utilisateur")
     */
    private $localite;

    /**
     * @ORM\ManyToOne(targetEntity=CodePostal::class, inversedBy="utilisateur")
     */
    private $cp;

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getAdresseNo(): ?string
    {
        return $this->adresseNo;
    }

    public function setAdresseNo(?string $adresseNo): self
    {
        $this->adresseNo = $adresseNo;

        return $this;
    }

    public function getAdresseRue(): ?string
    {
        return $this->adresseRue;
    }

    public function setAdresseRue(?string $adresseRue): self
    {
        $this->adresseRue = $adresseRue;

        return $this;
    }

    public function getDateInscription(): ?\DateTimeInterface
    {
        return $this->dateInscription;
    }

    public function setDateInscription(\DateTimeInterface $dateInscription): self
    {
        $this->dateInscription = $dateInscription;

        return $this;
    }

    public function isVisible(): ?bool
    {
        return $this->visible;
    }

    public function setVisible(bool $visible): self
    {
        $this->visible = $visible;

        return $this;
    }

    public function isInscriptConf(): ?bool
    {
        return $this->inscriptConf;
    }

    public function setInscriptConf(bool $inscriptConf): self
    {
        $this->inscriptConf = $inscriptConf;

        return $this;
    }

    public function getNbreEssai(): ?int
    {
        return $this->nbreEssai;
    }

    public function setNbreEssai(?int $nbreEssai): self
    {
        $this->nbreEssai = $nbreEssai;

        return $this;
    }

    public function getPrestataire(): ?Prestataire
    {
        return $this->prestataire;
    }

    public function setPrestataire(?Prestataire $prestataire): self
    {
        $this->prestataire = $prestataire;

        return $this;
    }

    public function getInternaute(): ?Internaute
    {
        return $this->internaute;
    }

    public function setInternaute(?Internaute $internaute): self
    {
        $this->internaute = $internaute;

        return $this;
    }

    public function getCommune(): ?Commune
    {
        return $this->commune;
    }

    public function setCommune(?Commune $commune): self
    {
        $this->commune = $commune;

        return $this;
    }

    public function getLocalite(): ?Localite
    {
        return $this->localite;
    }

    public function setLocalite(?Localite $localite): self
    {
        $this->localite = $localite;

        return $this;
    }

    public function getCp(): ?CodePostal
    {
        return $this->cp;
    }

    public function setCp(?CodePostal $cp): self
    {
        $this->cp = $cp;

        return $this;
    }
}
