<?php

namespace App\Entity;

use App\Repository\PromotionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PromotionRepository::class)
 */
class Promotion
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
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=Prestataire::class, inversedBy="promotion")
     * @ORM\JoinColumn(nullable=false)
     */
    private $prestataire;

    /**
     * @ORM\ManyToOne(targetEntity=Categorie::class, inversedBy="promotion")
     * @ORM\JoinColumn(nullable=false)
     */
    private $categorie;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $debutAffichage;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $finAffichage;


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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

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

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getDebutAffichage(): ?\DateTimeInterface
    {
        return $this->debutAffichage;
    }

    public function setDebutAffichage(?\DateTimeInterface $debutAffichage): self
    {
        $this->debutAffichage = $debutAffichage;

        return $this;
    }

    public function getFinAffichage(): ?\DateTimeInterface
    {
        return $this->finAffichage;
    }

    public function setFinAffichage(?\DateTimeInterface $finAffichage): self
    {
        $this->finAffichage = $finAffichage;

        return $this;
    }


}
