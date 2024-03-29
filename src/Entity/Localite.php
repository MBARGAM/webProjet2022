<?php

namespace App\Entity;

use App\Repository\LocaliteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LocaliteRepository::class)
 */
class Localite
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
    private $localite;

   /* /**
     * @ORM\ManyToOne(targetEntity=Commune::class, inversedBy="localite")

    private $commune;

    /**
     * @ORM\ManyToOne(targetEntity=CodePostal::class, inversedBy="localite")

    private $cp;*/

    /**
     * @ORM\OneToMany(targetEntity=Utilisateur::class, mappedBy="localite")
     */
    private $utilisateur;

    /**
     * @ORM\OneToMany(targetEntity=Commune::class, mappedBy="localite")
     */
    private $commune;

    /**
     * @ORM\OneToMany(targetEntity=CodePostal::class, mappedBy="localite")
     */
    private $codePostals;

    public function __construct()
    {
        $this->utilisateur = new ArrayCollection();
        $this->commune = new ArrayCollection();
        $this->codePostals = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLocalite(): ?string
    {
        return $this->localite;
    }

    public function setLocalite(?string $localite): self
    {
        $this->localite = $localite;

        return $this;
    }

  /*  public function getCommune(): ?Commune
    {
        return $this->commune;
    }

    public function setCommune(?Commune $commune): self
    {
        $this->commune = $commune;

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
    }*/

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
            $utilisateur->setLocalite($this);
        }

        return $this;
    }

    public function removeUtilisateur(Utilisateur $utilisateur): self
    {
        if ($this->utilisateur->removeElement($utilisateur)) {
            // set the owning side to null (unless already changed)
            if ($utilisateur->getLocalite() === $this) {
                $utilisateur->setLocalite(null);
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
            $commune->setLocalite($this);
        }

        return $this;
    }

    public function removeCommune(Commune $commune): self
    {
        if ($this->commune->removeElement($commune)) {
            // set the owning side to null (unless already changed)
            if ($commune->getLocalite() === $this) {
                $commune->setLocalite(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CodePostal>
     */
    public function getCodePostals(): Collection
    {
        return $this->codePostals;
    }

    public function addCodePostal(CodePostal $codePostal): self
    {
        if (!$this->codePostals->contains($codePostal)) {
            $this->codePostals[] = $codePostal;
            $codePostal->setLocalite($this);
        }

        return $this;
    }

    public function removeCodePostal(CodePostal $codePostal): self
    {
        if ($this->codePostals->removeElement($codePostal)) {
            // set the owning side to null (unless already changed)
            if ($codePostal->getLocalite() === $this) {
                $codePostal->setLocalite(null);
            }
        }

        return $this;
    }
}
