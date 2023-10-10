<?php

namespace App\Entity;

use Serializable;
use App\Entity\Note\SkillNote;
use Doctrine\DBAL\Types\Types;
use App\Entity\Identity\Social;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Identity\Formation;
use App\Entity\Identity\Experience;
use App\Entity\Views\IdentityViews;
use App\Repository\IdentityRepository;
use App\Entity\Identity\SpokenLanguage;
use App\Entity\Identity\TechnicalSkill;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: IdentityRepository::class)]
#[Vich\Uploadable]
class Identity implements Serializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'identity', cascade: ['persist', 'remove'])]
    private ?User $user = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $bio = null;

    #[ORM\Column(length: 255)]
    private ?string $username = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $phone = null;

    #[ORM\ManyToOne(inversedBy: 'identity')]
    private ?Account $account = null;

    #[Vich\UploadableField(mapping: 'cv_expert', fileNameProperty: 'fileName')]
    private ?File $file = null;
    
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $fileName = null;

    #[ORM\OneToOne(mappedBy: 'identity', cascade: ['persist', 'remove'])]
    private ?Company $company = null;

    #[ORM\OneToOne(mappedBy: 'identity', cascade: ['persist', 'remove'])]
    private ?Expert $expert = null;

    #[ORM\OneToMany(mappedBy: 'identity', targetEntity: IdentityViews::class)]
    private Collection $views;

    #[ORM\OneToMany(mappedBy: 'identity', targetEntity: SpokenLanguage::class, cascade: ['persist', 'remove'])]
    private Collection $languages;

    #[ORM\OneToMany(mappedBy: 'identity', targetEntity: Experience::class, cascade: ['persist', 'remove'])]
    private Collection $experiences;

    #[ORM\ManyToMany(targetEntity: TechnicalSkill::class, mappedBy: 'identity', cascade: ['persist', 'remove'])]
    private Collection $technicalSkills;

    #[ORM\OneToMany(mappedBy: 'identity', targetEntity: SkillNote::class)]
    private Collection $skillNotes;

    #[ORM\OneToMany(mappedBy: 'identity', targetEntity: Application::class)]
    private Collection $applications;

    #[ORM\ManyToMany(targetEntity: Formation::class, mappedBy: 'identity', cascade: ['persist', 'remove'])]
    private Collection $formations;

    #[ORM\OneToOne(mappedBy: 'identity', cascade: ['persist', 'remove'])]
    private ?Social $social = null;

    public function __construct()
    {
        $this->views = new ArrayCollection();
        $this->languages = new ArrayCollection();
        $this->experiences = new ArrayCollection();
        $this->technicalSkills = new ArrayCollection();
        $this->skillNotes = new ArrayCollection();
        $this->applications = new ArrayCollection();
        $this->formations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

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

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getBio(): ?string
    {
        return $this->bio;
    }

    public function setBio(?string $bio): static
    {
        $this->bio = $bio;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

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

    public function getAccount(): ?Account
    {
        return $this->account;
    }

    public function setAccount(?Account $account): static
    {
        $this->account = $account;

        return $this;
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): static
    {
        // unset the owning side of the relation if necessary
        if ($company === null && $this->company !== null) {
            $this->company->setIdentity(null);
        }

        // set the owning side of the relation if necessary
        if ($company !== null && $company->getIdentity() !== $this) {
            $company->setIdentity($this);
        }

        $this->company = $company;

        return $this;
    }

    public function getExpert(): ?Expert
    {
        return $this->expert;
    }

    public function setExpert(?Expert $expert): static
    {
        // unset the owning side of the relation if necessary
        if ($expert === null && $this->expert !== null) {
            $this->expert->setIdentity(null);
        }

        // set the owning side of the relation if necessary
        if ($expert !== null && $expert->getIdentity() !== $this) {
            $expert->setIdentity($this);
        }

        $this->expert = $expert;

        return $this;
    }

    public function setFile(?File $file = null): void
    {
        $this->file = $file;

        if (null !== $file) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTime();
        }

    }

    public function getFile(): ?File
    {
        return $this->file;
    }

    public function getFileName(): ?string
    {
        return $this->fileName;
    }

    public function setFileName(?string $fileName): static
    {
        $this->fileName = $fileName;

        return $this;
    }
    
    public function serialize()
    {
        $this->fileName = base64_encode($this->fileName);
    }

    public function unserialize($serialized)
    {
        $this->fileName = base64_decode($this->fileName);

    }

    /**
     * @return Collection<int, IdentityViews>
     */
    public function getViews(): Collection
    {
        return $this->views;
    }

    public function addView(IdentityViews $view): static
    {
        if (!$this->views->contains($view)) {
            $this->views->add($view);
            $view->setIdentity($this);
        }

        return $this;
    }

    public function removeView(IdentityViews $view): static
    {
        if ($this->views->removeElement($view)) {
            // set the owning side to null (unless already changed)
            if ($view->getIdentity() === $this) {
                $view->setIdentity(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, SpokenLanguage>
     */
    public function getLanguages(): Collection
    {
        return $this->languages;
    }

    public function addLanguage(SpokenLanguage $language): static
    {
        if (!$this->languages->contains($language)) {
            $this->languages->add($language);
            $language->setIdentity($this);
        }

        return $this;
    }

    public function removeLanguage(SpokenLanguage $language): static
    {
        if ($this->languages->removeElement($language)) {
            // set the owning side to null (unless already changed)
            if ($language->getIdentity() === $this) {
                $language->setIdentity(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Experience>
     */
    public function getExperiences(): Collection
    {
        return $this->experiences;
    }

    public function addExperience(Experience $experience): static
    {
        if (!$this->experiences->contains($experience)) {
            $this->experiences->add($experience);
            $experience->setIdentity($this);
        }

        return $this;
    }

    public function removeExperience(Experience $experience): static
    {
        if ($this->experiences->removeElement($experience)) {
            // set the owning side to null (unless already changed)
            if ($experience->getIdentity() === $this) {
                $experience->setIdentity(null);
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
            $technicalSkill->addIdentity($this);
        }

        return $this;
    }

    public function removeTechnicalSkill(TechnicalSkill $technicalSkill): static
    {
        if ($this->technicalSkills->removeElement($technicalSkill)) {
            $technicalSkill->removeIdentity($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, SkillNote>
     */
    public function getSkillNotes(): Collection
    {
        return $this->skillNotes;
    }

    public function addSkillNote(SkillNote $skillNote): static
    {
        if (!$this->skillNotes->contains($skillNote)) {
            $this->skillNotes->add($skillNote);
            $skillNote->setIdentity($this);
        }

        return $this;
    }

    public function removeSkillNote(SkillNote $skillNote): static
    {
        if ($this->skillNotes->removeElement($skillNote)) {
            // set the owning side to null (unless already changed)
            if ($skillNote->getIdentity() === $this) {
                $skillNote->setIdentity(null);
            }
        }

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
            $application->setIdentity($this);
        }

        return $this;
    }

    public function removeApplication(Application $application): static
    {
        if ($this->applications->removeElement($application)) {
            // set the owning side to null (unless already changed)
            if ($application->getIdentity() === $this) {
                $application->setIdentity(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Formation>
     */
    public function getFormations(): Collection
    {
        return $this->formations;
    }

    public function addFormation(Formation $formation): static
    {
        if (!$this->formations->contains($formation)) {
            $this->formations->add($formation);
            $formation->addIdentity($this);
        }

        return $this;
    }

    public function removeFormation(Formation $formation): static
    {
        if ($this->formations->removeElement($formation)) {
            $formation->removeIdentity($this);
        }

        return $this;
    }

    public function getSocial(): ?Social
    {
        return $this->social;
    }

    public function setSocial(?Social $social): static
    {
        // unset the owning side of the relation if necessary
        if ($social === null && $this->social !== null) {
            $this->social->setIdentity(null);
        }

        // set the owning side of the relation if necessary
        if ($social !== null && $social->getIdentity() !== $this) {
            $social->setIdentity($this);
        }

        $this->social = $social;

        return $this;
    }
}
