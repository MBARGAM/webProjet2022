<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategorieRepository::class)
 */
class Categorie
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
     * @ORM\Column(type="boolean")
     */
    private $validation;

    /**
     * @ORM\Column(type="boolean")
     */
    private $misEnAvant;

    /**
     * @ORM\ManyToMany(targetEntity=Prestataire::class, inversedBy="categorie")
     */
    private $prestataire;

    /**
     * @ORM\OneToMany(targetEntity=Promotion::class, mappedBy="categorie")
     */
    private $promotion;

    /**
     * @ORM\OneToOne(targetEntity=Image::class, mappedBy="categorie", cascade={"persist", "remove"})
     */
    private $image;

    public function __construct()
    {
        $this->prestataire = new ArrayCollection();
        $this->promotion = new ArrayCollection();
    }

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

    public function isValidation(): ?bool
    {
        return $this->validation;
    }

    public function setValidation(bool $validation): self
    {
        $this->validation = $validation;

        return $this;
    }

    public function isMisEnAvant(): ?bool
    {
        return $this->misEnAvant;
    }

    public function setMisEnAvant(bool $misEnAvant): self
    {
        $this->misEnAvant = $misEnAvant;

        return $this;
    }

    /**
     * @return Collection<int, Prestataire>
     */
    public function getPrestataire(): Collection
    {
        return $this->prestataire;
    }

    public function addPrestataire(Prestataire $prestataire): self
    {
        if (!$this->prestataire->contains($prestataire)) {
            $this->prestataire[] = $prestataire;
        }

        return $this;
    }

    public function removePrestataire(Prestataire $prestataire): self
    {
        $this->prestataire->removeElement($prestataire);

        return $this;
    }

    /**
     * @return Collection<int, Promotion>
     */
    public function getPromotion(): Collection
    {
        return $this->promotion;
    }

    public function addPromotion(Promotion $promotion): self
    {
        if (!$this->promotion->contains($promotion)) {
            $this->promotion[] = $promotion;
            $promotion->setCategorie($this);
        }

        return $this;
    }

    public function removePromotion(Promotion $promotion): self
    {
        if ($this->promotion->removeElement($promotion)) {
            // set the owning side to null (unless already changed)
            if ($promotion->getCategorie() === $this) {
                $promotion->setCategorie(null);
            }
        }

        return $this;
    }

    public function getImage(): ?Image
    {
        return $this->image;
    }

    public function setImage(?Image $image): self
    {
        // unset the owning side of the relation if necessary
        if ($image === null && $this->image !== null) {
            $this->image->setCategorie(null);
        }

        // set the owning side of the relation if necessary
        if ($image !== null && $image->getCategorie() !== $this) {
            $image->setCategorie($this);
        }

        $this->image = $image;

        return $this;
    }
    public function __toString()
    {
        return $this->getNom();
    }
}
