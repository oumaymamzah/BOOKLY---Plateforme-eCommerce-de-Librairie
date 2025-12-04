<?php

namespace App\Entity;

use App\Repository\LivreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LivreRepository::class)]
class Livre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 150)]
    private ?string $titre = null;

    #[ORM\Column]
    private ?int $qte = null;  // ⚠️ Correction: minuscule 'qte' au lieu de 'Qte'

    #[ORM\Column]
    private ?float $prixUnitaire = null;

    #[ORM\Column(type: Types::BIGINT, options: ['unsigned' => true])]
    private ?string $isbn = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $datepub = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Editeur $editeurs = null;

    /**
     * @var Collection<int, Auteur>
     */
    #[ORM\ManyToMany(targetEntity: Auteur::class, inversedBy: 'livres')]
    private Collection $auteurs;

    #[ORM\ManyToOne(inversedBy: 'livres')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Categorie $categorie = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $pdfFilename = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    public function __construct()
    {
        $this->auteurs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;
        return $this;
    }

    public function getQte(): ?int
    {
        return $this->qte;  // ⚠️ Correction: minuscule
    }

    public function setQte(int $qte): static  // ⚠️ Correction: paramètre en minuscule
    {
        $this->qte = $qte;  // ⚠️ Correction: minuscule
        return $this;
    }

    public function getPrixUnitaire(): ?float
    {
        return $this->prixUnitaire;
    }

    public function setPrixUnitaire(float $prixUnitaire): static
    {
        $this->prixUnitaire = $prixUnitaire;
        return $this;
    }

    public function getIsbn(): ?string
    {
        return $this->isbn;
    }

    public function setIsbn(string $isbn): static
    {
        $this->isbn = $isbn;
        return $this;
    }

    public function getDatepub(): ?\DateTime
    {
        return $this->datepub;
    }

    public function getDatepubFormatted(): ?string
    {
        return $this->datepub ? $this->datepub->format('Y-m-d') : null;
    }

    public function setDatepubFormatted(?string $datepubFormatted): static
    {
        if ($datepubFormatted) {
            $this->datepub = new \DateTime($datepubFormatted);
        } else {
            $this->datepub = null;
        }
        return $this;
    }


    public function getDatepubString(): ?string
    {
        return $this->datepub ? $this->datepub->format('Y-m-d') : null;
    }

    public function setDatepub(\DateTime|string $datepub): static
    {
        if (is_string($datepub)) {
            $this->datepub = new \DateTime($datepub);
        } else {
            $this->datepub = $datepub;
        }
        return $this;
    }

    public function getEditeurs(): ?Editeur
    {
        return $this->editeurs;
    }

    public function setEditeurs(?Editeur $editeurs): static
    {
        $this->editeurs = $editeurs;
        return $this;
    }

    /**
     * @return Collection<int, Auteur>
     */
    public function getAuteurs(): Collection
    {
        return $this->auteurs;
    }

    public function addAuteur(Auteur $auteur): static
    {
        if (!$this->auteurs->contains($auteur)) {
            $this->auteurs->add($auteur);
        }
        return $this;
    }

    public function removeAuteur(Auteur $auteur): static
    {
        $this->auteurs->removeElement($auteur);
        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): static
    {
        $this->categorie = $categorie;
        return $this;
    }

    public function getPdfFilename(): ?string
    {
        return $this->pdfFilename;
    }

    public function setPdfFilename(?string $pdfFilename): static
    {
        $this->pdfFilename = $pdfFilename;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;
        return $this;
    }

    // ⚠️ IMPORTANT: Ajoutez cette méthode pour l'affichage dans EasyAdmin
    public function __toString(): string
    {
        return $this->titre ?? 'Livre #' . $this->id;
    }
}