<?php

namespace App\Entity;

use App\Repository\CodePostalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CodePostalRepository::class)
 */
class CodePostal
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cp;

    /*/**
     * @ORM\OneToMany(targetEntity=Localite::class, mappedBy="cp")

    private $localite;*/

    /**
     * @ORM\OneToMany(targetEntity=Commune::class, mappedBy="cp")
     */
    private $commune;

    /**
     * @ORM\OneToMany(targetEntity=Utilisateur::class, mappedBy="cp")
     */
    private $utilisateur;

    /**
     * @ORM\ManyToOne(targetEntity=Localite::class, inversedBy="codePostals")
     */
    private $localite;

    public function __construct()
    {
        $this->localite = new ArrayCollection();
        $this->commune = new ArrayCollection();
        $this->utilisateur = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCp(): ?string
    {
        return $this->cp;
    }

    public function setCp(?string $cp): self
    {
        $this->cp = $cp;

        return $this;
    }

   /* /**
     * @return Collection<int, Localite>

    public function getLocalite(): Collection
    {
        return $this->localite;
    }

    public function addLocalite(Localite $localite): self
    {
        if (!$this->localite->contains($localite)) {
            $this->localite[] = $localite;
            $localite->setCp($this);
        }

        return $this;
    }*/

    public function removeLocalite(Localite $localite): self
    {
        if ($this->localite->removeElement($localite)) {
            // set the owning side to null (unless already changed)
            if ($localite->getCp() === $this) {
                $localite->setCp(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Commune>
     */
    public function getCommune(): Collection
    {
        return $this->commune;
    }

    public function addCommune(Commune $commune): self
    {
        if (!$this->commune->contains($commune)) {
            $this->commune[] = $commune;
            $commune->setCp($this);
        }

        return $this;
    }

    public function removeCommune(Commune $commune): self
    {
        if ($this->commune->removeElement($commune)) {
            // set the owning side to null (unless already changed)
            if ($commune->getCp() === $this) {
                $commune->setCp(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Utilisateur>
     */
    public function getUtilisateur(): Collection
    {
        return $this->utilisateur;
    }

    public function addUtilisateur(Utilisateur $utilisateur): self
    {
        if (!$this->utilisateur->contains($utilisateur)) {
            $this->utilisateur[] = $utilisateur;
            $utilisateur->setCp($this);
        }

        return $this;
    }

    public function removeUtilisateur(Utilisateur $utilisateur): self
    {
        if ($this->utilisateur->removeElement($utilisateur)) {
            // set the owning side to null (unless already changed)
            if ($utilisateur->getCp() === $this) {
                $utilisateur->setCp(null);
            }
        }

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
}
