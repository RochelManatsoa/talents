<?php

namespace App\Entity\Type;

use App\Entity\Company;
use App\Entity\Expert;
use App\Entity\Posting;
use App\Repository\Type\PostingTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PostingTypeRepository::class)]
class PostingType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $slug = null;

    #[ORM\OneToMany(mappedBy: 'type', targetEntity: Posting::class)]
    private Collection $posting;

    #[ORM\ManyToMany(targetEntity: Company::class, inversedBy: 'typeSearch')]
    private Collection $companies;

    #[ORM\ManyToMany(targetEntity: Expert::class, inversedBy: 'typeJob')]
    private Collection $experts;

    public function __construct()
    {
        $this->posting = new ArrayCollection();
        $this->companies = new ArrayCollection();
        $this->experts = new ArrayCollection();
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

    /**
     * @return Collection<int, Posting>
     */
    public function getPosting(): Collection
    {
        return $this->posting;
    }

    public function addPosting(Posting $posting): static
    {
        if (!$this->posting->contains($posting)) {
            $this->posting->add($posting);
            $posting->setType($this);
        }

        return $this;
    }

    public function removePosting(Posting $posting): static
    {
        if ($this->posting->removeElement($posting)) {
            // set the owning side to null (unless already changed)
            if ($posting->getType() === $this) {
                $posting->setType(null);
            }
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
        }

        return $this;
    }

    public function removeCompany(Company $company): static
    {
        $this->companies->removeElement($company);

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
        }

        return $this;
    }

    public function removeExpert(Expert $expert): static
    {
        $this->experts->removeElement($expert);

        return $this;
    }
}
