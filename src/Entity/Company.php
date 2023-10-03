<?php

namespace App\Entity;

use App\Entity\Type\PostingType;
use App\Repository\CompanyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CompanyRepository::class)]
class Company
{
    const SIZE_SMALL = 'SM';
    const SIZE_MEDIUM = 'MD';
    const SIZE_LARGE = 'LG';

    const CHOICE_SIZE = [        
         'Petite (1-10 employés)' => self::SIZE_SMALL ,
         'Moyenne (11-100 employés)' => self::SIZE_MEDIUM ,
         'Grande (plus de 100 employés)' => self::SIZE_LARGE ,
    ];
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $size = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $website = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $country = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $phone = null;

    #[ORM\OneToOne(inversedBy: 'company', cascade: ['persist', 'remove'])]
    private ?Identity $identity = null;

    #[ORM\OneToMany(mappedBy: 'company', targetEntity: Posting::class)]
    private Collection $postings;

    #[ORM\ManyToMany(targetEntity: PostingType::class, mappedBy: 'companies')]
    private Collection $typeSearch;

    public function __construct()
    {
        $this->postings = new ArrayCollection();
        $this->typeSearch = new ArrayCollection();
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

    public function getSize(): ?string
    {
        return $this->size;
    }

    public function setSize(?string $size): static
    {
        $this->size = $size;

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

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    public function setWebsite(?string $website): static
    {
        $this->website = $website;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): static
    {
        $this->country = $country;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getIdentity(): ?Identity
    {
        return $this->identity;
    }

    public function setIdentity(?Identity $identity): static
    {
        $this->identity = $identity;

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
            $posting->setCompany($this);
        }

        return $this;
    }

    public function removePosting(Posting $posting): static
    {
        if ($this->postings->removeElement($posting)) {
            // set the owning side to null (unless already changed)
            if ($posting->getCompany() === $this) {
                $posting->setCompany(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PostingType>
     */
    public function getTypeSearch(): Collection
    {
        return $this->typeSearch;
    }

    public function addTypeSearch(PostingType $typeSearch): static
    {
        if (!$this->typeSearch->contains($typeSearch)) {
            $this->typeSearch->add($typeSearch);
            $typeSearch->addCompany($this);
        }

        return $this;
    }

    public function removeTypeSearch(PostingType $typeSearch): static
    {
        if ($this->typeSearch->removeElement($typeSearch)) {
            $typeSearch->removeCompany($this);
        }

        return $this;
    }

}
