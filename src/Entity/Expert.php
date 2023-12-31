<?php

namespace App\Entity;

use App\Entity\Type\PostingType;
use App\Repository\ExpertRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExpertRepository::class)]
class Expert
{
    const YEAR_SMALL = 'SM';
    const YEAR_MEDIUM = 'MD';
    const YEAR_LARGE = 'LG';
    const YEAR_XLARGE = 'LG';

    const CHOICE_YEAR = [        
         'Moins d\'1 an' => self::YEAR_SMALL ,
         '1-3 ans' => self::YEAR_MEDIUM ,
         '3-5 ans' => self::YEAR_LARGE ,
         'Plus de 5 ans' => self::YEAR_XLARGE ,
    ];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['identity'])]
    #[ORM\OneToOne(inversedBy: 'expert', cascade: ['persist', 'remove'])]
    private ?Identity $identity = null;

    #[Groups(['identity'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $title = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $years = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $country = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $mainSkills = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $aspiration = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $preference = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $website = null;

    #[ORM\ManyToMany(targetEntity: PostingType::class, mappedBy: 'experts')]
    private Collection $jobTypes;

    #[ORM\ManyToMany(targetEntity: PostingType::class, mappedBy: 'experts')]
    private Collection $typeJob;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $birthday = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $cv = null;

    #[ORM\ManyToMany(targetEntity: Sector::class, inversedBy: 'experts')]
    private Collection $sectors;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $phone = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email = null;

    public function __construct()
    {
        $this->jobTypes = new ArrayCollection();
        $this->typeJob = new ArrayCollection();
        $this->sectors = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getYears(): ?string
    {
        return $this->years;
    }

    public function setYears(?string $years): static
    {
        $this->years = $years;

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

    public function getMainSkills(): ?string
    {
        return $this->mainSkills;
    }

    public function setMainSkills(?string $mainSkills): static
    {
        $this->mainSkills = $mainSkills;

        return $this;
    }

    public function getAspiration(): ?string
    {
        return $this->aspiration;
    }

    public function setAspiration(?string $aspiration): static
    {
        $this->aspiration = $aspiration;

        return $this;
    }

    public function getPreference(): ?string
    {
        return $this->preference;
    }

    public function setPreference(?string $preference): static
    {
        $this->preference = $preference;

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

    /**
     * @return Collection<int, PostingType>
     */
    public function getJobTypes(): Collection
    {
        return $this->jobTypes;
    }

    public function addJobType(PostingType $jobType): static
    {
        if (!$this->jobTypes->contains($jobType)) {
            $this->jobTypes->add($jobType);
            $jobType->addExpert($this);
        }

        return $this;
    }

    public function removeJobType(PostingType $jobType): static
    {
        if ($this->jobTypes->removeElement($jobType)) {
            $jobType->removeExpert($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, PostingType>
     */
    public function getTypeJob(): Collection
    {
        return $this->typeJob;
    }

    public function addTypeJob(PostingType $typeJob): static
    {
        if (!$this->typeJob->contains($typeJob)) {
            $this->typeJob->add($typeJob);
            $typeJob->addExpert($this);
        }

        return $this;
    }

    public function removeTypeJob(PostingType $typeJob): static
    {
        if ($this->typeJob->removeElement($typeJob)) {
            $typeJob->removeExpert($this);
        }

        return $this;
    }

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(?\DateTimeInterface $birthday): static
    {
        $this->birthday = $birthday;

        return $this;
    }

    public function getCv(): ?string
    {
        return $this->cv;
    }

    public function setCv(?string $cv): static
    {
        $this->cv = $cv;

        return $this;
    }

    /**
     * @return Collection<int, Sector>
     */
    public function getSectors(): Collection
    {
        return $this->sectors;
    }

    public function addSector(Sector $sector): static
    {
        if (!$this->sectors->contains($sector)) {
            $this->sectors->add($sector);
        }

        return $this;
    }

    public function removeSector(Sector $sector): static
    {
        $this->sectors->removeElement($sector);

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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

        return $this;
    }
}
