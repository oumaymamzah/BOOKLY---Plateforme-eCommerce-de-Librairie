<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategorieRepository::class)]
class Categorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nom = null;

    #[ORM\Column(length: 100)]
    private ?string $designation = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imageFilename = null;

    /**
     * @var Collection<int, Livre>
     */
    #[ORM\OneToMany(targetEntity: Livre::class, mappedBy: 'categorie', orphanRemoval: true)]
    private Collection $livres;

    public function __construct()
    {
        $this->livres = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;
        return $this;
    }

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(string $designation): static  // ⚠️ CORRECTION: "string" pas "text"
    {
        $this->designation = $designation;
        return $this;
    }

    public function getImageFilename(): ?string
    {
        return $this->imageFilename;
    }

    public function setImageFilename(?string $imageFilename): static
    {
        $this->imageFilename = $imageFilename;
        return $this;
    }

    /**
     * @return Collection<int, Livre>
     */
    public function getLivres(): Collection
    {
        return $this->livres;
    }

    public function addLivre(Livre $livre): static
    {
        if (!$this->livres->contains($livre)) {
            $this->livres->add($livre);
            $livre->setCategorie($this);
        }
        return $this;
    }

    public function removeLivre(Livre $livre): static
    {
        if ($this->livres->removeElement($livre)) {
            if ($livre->getCategorie() === $this) {
                $livre->setCategorie(null);
            }
        }
        return $this;
    }

    // ✅ __toString() utilise 'nom' maintenant
    public function __toString(): string
    {
        return $this->nom ?? $this->designation ?? '';
    }
}