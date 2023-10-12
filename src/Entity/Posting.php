<?php

namespace App\Entity;

use App\Entity\Identity\TechnicalSkill;
use App\Entity\Type\PostingType;
use App\Entity\Views\PostingViews;
use App\Repository\PostingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: PostingRepository::class)]
class Posting
{
    const STATUS_DRAFT = 'DRAFT';
    const STATUS_PUBLISHED = 'PUBLISHED';
    const STATUS_PENDING = 'PENDING';
    const STATUS_REJECTED = 'REJECTED';
    const STATUS_EXPIRED = 'EXPIRED';
    const STATUS_ARCHIVED = 'ARCHIVED';
    const STATUS_UNPUBLISHED = 'UNPUBLISHED';
    const STATUS_DELETED = 'DELETED';
    const STATUS_FEATURED = 'FEATURED';
    const STATUS_RESERVED = 'RESERVED';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $tarif = null;

    #[ORM\ManyToOne(inversedBy: 'postings')]
    private ?Sector $sector = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updatesAt = null;

    #[ORM\Column(nullable: true)]
    private ?int $number = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isValid = null;

    #[ORM\Column(type: 'uuid')]
    private ?Uuid $jobId = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $plannedDate = null;

    #[ORM\ManyToOne(inversedBy: 'postings')]
    private ?Company $company = null;

    #[ORM\OneToMany(mappedBy: 'posting', targetEntity: PostingViews::class)]
    private Collection $views;

    #[ORM\ManyToOne(inversedBy: 'posting')]
    private ?PostingType $type = null;

    #[ORM\OneToMany(mappedBy: 'posting', targetEntity: Application::class)]
    private Collection $applications;

    #[ORM\ManyToMany(targetEntity: TechnicalSkill::class, inversedBy: 'postings')]
    private Collection $technicalSkills;

    #[ORM\ManyToMany(targetEntity: Language::class, inversedBy: 'postings')]
    private Collection $languages;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $status = null;

    public function __construct()
    {
        $this->views = new ArrayCollection();
        $this->applications = new ArrayCollection();
        $this->technicalSkills = new ArrayCollection();
        $this->languages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

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

    public function getTarif(): ?string
    {
        return $this->tarif;
    }

    public function setTarif(?string $tarif): static
    {
        $this->tarif = $tarif;

        return $this;
    }

    public function getSector(): ?Sector
    {
        return $this->sector;
    }

    public function setSector(?Sector $sector): static
    {
        $this->sector = $sector;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatesAt(): ?\DateTimeInterface
    {
        return $this->updatesAt;
    }

    public function setUpdatesAt(?\DateTimeInterface $updatesAt): static
    {
        $this->updatesAt = $updatesAt;

        return $this;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(?int $number): static
    {
        $this->number = $number;

        return $this;
    }

    public function isIsValid(): ?bool
    {
        return $this->isValid;
    }

    public function setIsValid(?bool $isValid): static
    {
        $this->isValid = $isValid;

        return $this;
    }

    public function getJobId(): ?Uuid
    {
        return $this->jobId;
    }

    public function setJobId(Uuid $jobId): static
    {
        $this->jobId = $jobId;

        return $this;
    }

    public function getPlannedDate(): ?\DateTimeInterface
    {
        return $this->plannedDate;
    }

    public function setPlannedDate(?\DateTimeInterface $plannedDate): static
    {
        $this->plannedDate = $plannedDate;

        return $this;
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): static
    {
        $this->company = $company;

        return $this;
    }

    /**
     * @return Collection<int, PostingViews>
     */
    public function getViews(): Collection
    {
        return $this->views;
    }

    public function addView(PostingViews $view): static
    {
        if (!$this->views->contains($view)) {
            $this->views->add($view);
            $view->setPosting($this);
        }

        return $this;
    }

    public function removeView(PostingViews $view): static
    {
        if ($this->views->removeElement($view)) {
            // set the owning side to null (unless already changed)
            if ($view->getPosting() === $this) {
                $view->setPosting(null);
            }
        }

        return $this;
    }

    public function getType(): ?PostingType
    {
        return $this->type;
    }

    public function setType(?PostingType $type): static
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection<int, Application>
     */
    public function getApplications(): Collection
    {
        return $this->applications;
    }

    public function addApplication(Application $application): static
    {
        if (!$this->applications->contains($application)) {
            $this->applications->add($application);
            $application->setPosting($this);
        }

        return $this;
    }

    public function removeApplication(Application $application): static
    {
        if ($this->applications->removeElement($application)) {
            // set the owning side to null (unless already changed)
            if ($application->getPosting() === $this) {
                $application->setPosting(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TechnicalSkill>
     */
    public function getTechnicalSkills(): Collection
    {
        return $this->technicalSkills;
    }

    public function addTechnicalSkill(TechnicalSkill $technicalSkill): static
    {
        if (!$this->technicalSkills->contains($technicalSkill)) {
            $this->technicalSkills->add($technicalSkill);
        }

        return $this;
    }

    public function removeTechnicalSkill(TechnicalSkill $technicalSkill): static
    {
        $this->technicalSkills->removeElement($technicalSkill);

        return $this;
    }

    /**
     * @return Collection<int, Language>
     */
    public function getLanguages(): Collection
    {
        return $this->languages;
    }

    public function addLanguage(Language $language): static
    {
        if (!$this->languages->contains($language)) {
            $this->languages->add($language);
        }

        return $this;
    }

    public function removeLanguage(Language $language): static
    {
        $this->languages->removeElement($language);

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function isApplyByIdentity(Identity $identity): bool
    {
        foreach ($this->applications as $application) {
            if ($application->getIdentity() === $identity) {
                return true;  // L'identité a postulé pour ce poste.
            }
        }
        return false;  // L'identité n'a pas postulé pour ce poste.
    }
}
