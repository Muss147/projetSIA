<?php

namespace App\Entity;

use App\Mapping\EntityBase;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\BPURepository;
use Symfony\Component\String\Slugger\AsciiSlugger;

#[ORM\Entity(repositoryClass: BPURepository::class)]
class BPU extends EntityBase
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $unite = null;

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
    private ?Parametres $parametre = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    /**
     * @var Collection<int, DevisBPU>
     */
    #[ORM\OneToMany(targetEntity: DevisBPU::class, mappedBy: 'bpu')]
    private Collection $devis;

    public function __construct()
    {
        $this->devis = new ArrayCollection();
    }

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
        return $this->unite;
    }

    public function setUnite(string $unite): static
    {
        $this->unite = $unite;

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

    public function getParametre(): ?Parametres
    {
        return $this->parametre;
    }

    public function setParametre(?Parametres $parametre): static
    {
        $this->parametre = $parametre;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function generateSlug(): void
    {
        if ($this->designation) {
            $slugger = new AsciiSlugger('fr'); // Support du français
            $slug = $slugger->slug($this->designation)->lower();
            $this->slug = $slug;
        }
    }

    /**
     * @return Collection<int, DevisBPU>
     */
    public function getDevis(): Collection
    {
        return $this->devis;
    }

    public function addDevi(DevisBPU $devi): static
    {
        if (!$this->devis->contains($devi)) {
            $this->devis->add($devi);
            $devi->setBpu($this);
        }

        return $this;
    }

    public function removeDevi(DevisBPU $devi): static
    {
        if ($this->devis->removeElement($devi)) {
            // set the owning side to null (unless already changed)
            if ($devi->getBpu() === $this) {
                $devi->setBpu(null);
            }
        }

        return $this;
    }
}
