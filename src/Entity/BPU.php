<?php

namespace App\Entity;

use App\Mapping\EntityBase;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\BPURepository;

#[ORM\Entity(repositoryClass: BPURepository::class)]
class BPU extends EntityBase
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Unite = null;

    #[ORM\Column(nullable: true)]
    private ?int $materiaux = null;

    #[ORM\Column(nullable: true)]
    private ?int $mainDoeuvre = null;

    #[ORM\Column(nullable: true)]
    private ?int $materiel = null;

    #[ORM\Column(nullable: true)]
    private ?int $debourseSec = null;

    #[ORM\Column(nullable: true)]
    private ?int $fraisDeChantier = null;

    #[ORM\Column(nullable: true)]
    private ?int $fraisGeneraux = null;

    #[ORM\Column(nullable: true)]
    private ?int $margeNette = null;

    #[ORM\Column(nullable: true)]
    private ?int $prixUnitaireHT = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $prixUnitaire = null;

    #[ORM\Column(length: 255)]
    private ?string $designation = null;

    #[ORM\ManyToOne(inversedBy: 'bpu')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Parametres $parametres = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEntityLibelle(): ?string
    {
        return $this->designation;
    }

    public function getUnite(): ?string
    {
        return $this->Unite;
    }

    public function setUnite(string $Unite): static
    {
        $this->Unite = $Unite;

        return $this;
    }

    public function getMateriaux(): ?int
    {
        return $this->materiaux;
    }

    public function setMateriaux(?int $materiaux): static
    {
        $this->materiaux = $materiaux;

        return $this;
    }

    public function getMainDoeuvre(): ?int
    {
        return $this->mainDoeuvre;
    }

    public function setMainDoeuvre(?int $mainDoeuvre): static
    {
        $this->mainDoeuvre = $mainDoeuvre;

        return $this;
    }

    public function getMateriel(): ?int
    {
        return $this->materiel;
    }

    public function setMateriel(?int $materiel): static
    {
        $this->materiel = $materiel;

        return $this;
    }

    public function getDebourseSec(): ?int
    {
        return $this->debourseSec;
    }

    public function setDebourseSec(?int $debourseSec): static
    {
        $this->debourseSec = $debourseSec;

        return $this;
    }

    public function getFraisDeChantier(): ?int
    {
        return $this->fraisDeChantier;
    }

    public function setFraisDeChantier(?int $fraisDeChantier): static
    {
        $this->fraisDeChantier = $fraisDeChantier;

        return $this;
    }

    public function getFraisGeneraux(): ?int
    {
        return $this->fraisGeneraux;
    }

    public function setFraisGeneraux(?int $fraisGeneraux): static
    {
        $this->fraisGeneraux = $fraisGeneraux;

        return $this;
    }

    public function getMargeNette(): ?int
    {
        return $this->margeNette;
    }

    public function setMargeNette(?int $margeNette): static
    {
        $this->margeNette = $margeNette;

        return $this;
    }

    public function getPrixUnitaireHT(): ?int
    {
        return $this->prixUnitaireHT;
    }

    public function setPrixUnitaireHT(?int $prixUnitaireHT): static
    {
        $this->prixUnitaireHT = $prixUnitaireHT;

        return $this;
    }

    public function getPrixUnitaire(): ?string
    {
        return $this->prixUnitaire;
    }

    public function setPrixUnitaire(?string $prixUnitaire): static
    {
        $this->prixUnitaire = $prixUnitaire;

        return $this;
    }

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(string $designation): static
    {
        $this->designation = $designation;

        return $this;
    }

    public function getParametres(): ?Parametres
    {
        return $this->parametres;
    }

    public function setParametres(?Parametres $parametres): static
    {
        $this->parametres = $parametres;

        return $this;
    }
}
