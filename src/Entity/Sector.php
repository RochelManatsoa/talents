<?php

namespace App\Entity;

use App\Repository\SectorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SectorRepository::class)]
class Sector
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $slug = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'sector', targetEntity: Posting::class)]
    private Collection $postings;

    #[ORM\ManyToMany(targetEntity: Expert::class, mappedBy: 'sectors')]
    private Collection $experts;

    #[ORM\ManyToMany(targetEntity: Company::class, mappedBy: 'sectors')]
    private Collection $companies;

    public function __construct()
    {
        $this->postings = new ArrayCollection();
        $this->experts = new ArrayCollection();
        $this->companies = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->name;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): static
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

    /**
     * @return Collection<int, Posting>
     */
    public function getPostings(): Collection
    {
        return $this->postings;
    }

    public function addPosting(Posting $posting): static
    {
        if (!$this->postings->contains($posting)) {
            $this->postings->add($posting);
            $posting->setSector($this);
        }

        return $this;
    }

    public function removePosting(Posting $posting): static
    {
        if ($this->postings->removeElement($posting)) {
            // set the owning side to null (unless already changed)
            if ($posting->getSector() === $this) {
                $posting->setSector(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Expert>
     */
    public function getExperts(): Collection
    {
        return $this->experts;
    }

    public function addExpert(Expert $expert): static
    {
        if (!$this->experts->contains($expert)) {
            $this->experts->add($expert);
            $expert->addSector($this);
        }

        return $this;
    }

    public function removeExpert(Expert $expert): static
    {
        if ($this->experts->removeElement($expert)) {
            $expert->removeSector($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Company>
     */
    public function getCompanies(): Collection
    {
        return $this->companies;
    }

    public function addCompany(Company $company): static
    {
        if (!$this->companies->contains($company)) {
            $this->companies->add($company);
            $company->addSector($this);
        }

        return $this;
    }

    public function removeCompany(Company $company): static
    {
        if ($this->companies->removeElement($company)) {
            $company->removeSector($this);
        }

        return $this;
    }
}
