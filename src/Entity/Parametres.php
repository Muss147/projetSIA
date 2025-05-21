<?php

namespace App\Entity;

use App\Mapping\EntityBase;
use App\Repository\ParametresRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ParametresRepository::class)]
class Parametres extends EntityBase
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $libelle = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $type = null;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'children')]
    private ?self $parent = null;

    /**
     * @var Collection<int, self>
     */
    #[ORM\OneToMany(targetEntity: self::class, mappedBy: 'parent')]
    private Collection $children;

    /**
     * @var Collection<int, BPU>
     */
    #[ORM\OneToMany(targetEntity: BPU::class, mappedBy: 'parametres', orphanRemoval: true)]
    private Collection $bpu;

    public function __construct()
    {
        $this->children = new ArrayCollection();
        $this->bpu = new ArrayCollection();
    }

    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEntityLibelle(): ?string
    {
        return $this->libelle;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): static
    {
        $this->libelle = $libelle;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): static
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return Collection<int, Parametres>
     */
    public function getChildren(): Collection
    {
        return $this->children;
    }

    public function addChild(Parametres $child): static
    {
        if (!$this->children->contains($child)) {
            $this->children->add($child);
            $child->setParent($this);
        }

        return $this;
    }

    public function removeChild(Parametres $child): static
    {
        if ($this->children->removeElement($child)) {
            // set the owning side to null (unless already changed)
            if ($child->getParent() === $this) {
                $child->setParent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, BPU>
     */
    public function getBpu(): Collection
    {
        return $this->bpu;
    }

    public function addBpu(BPU $bpu): static
    {
        if (!$this->bpu->contains($bpu)) {
            $this->bpu->add($bpu);
            $bpu->setParametres($this);
        }

        return $this;
    }

    public function removeBpu(BPU $bpu): static
    {
        if ($this->bpu->removeElement($bpu)) {
            // set the owning side to null (unless already changed)
            if ($bpu->getParametres() === $this) {
                $bpu->setParametres(null);
            }
        }

        return $this;
    }

}
