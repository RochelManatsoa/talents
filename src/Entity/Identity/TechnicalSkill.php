<?php

namespace App\Entity\Identity;

use App\Entity\Identity;
use App\Entity\Note\SkillNote;
use App\Entity\Posting;
use App\Repository\Identity\TechnicalSkillRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TechnicalSkillRepository::class)]
class TechnicalSkill
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $slug = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $url = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $type = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    #[ORM\ManyToMany(targetEntity: Identity::class, inversedBy: 'technicalSkills')]
    private Collection $identity;

    #[ORM\ManyToMany(targetEntity: self::class, inversedBy: 'technicalSkills')]
    private Collection $experience;

    #[ORM\ManyToMany(targetEntity: self::class, mappedBy: 'experience')]
    private Collection $technicalSkills;

    #[ORM\OneToMany(mappedBy: 'technicalSkill', targetEntity: SkillNote::class)]
    private Collection $skillNotes;

    #[ORM\ManyToMany(targetEntity: Posting::class, mappedBy: 'technicalSkills')]
    private Collection $postings;

    public function __construct()
    {
        $this->identity = new ArrayCollection();
        $this->experience = new ArrayCollection();
        $this->technicalSkills = new ArrayCollection();
        $this->skillNotes = new ArrayCollection();
        $this->postings = new ArrayCollection();
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

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): static
    {
        $this->url = $url;

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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection<int, Identity>
     */
    public function getIdentity(): Collection
    {
        return $this->identity;
    }

    public function addIdentity(Identity $identity): static
    {
        if (!$this->identity->contains($identity)) {
            $this->identity->add($identity);
        }

        return $this;
    }

    public function removeIdentity(Identity $identity): static
    {
        $this->identity->removeElement($identity);

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getExperience(): Collection
    {
        return $this->experience;
    }

    public function addExperience(self $experience): static
    {
        if (!$this->experience->contains($experience)) {
            $this->experience->add($experience);
        }

        return $this;
    }

    public function removeExperience(self $experience): static
    {
        $this->experience->removeElement($experience);

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getTechnicalSkills(): Collection
    {
        return $this->technicalSkills;
    }

    public function addTechnicalSkill(self $technicalSkill): static
    {
        if (!$this->technicalSkills->contains($technicalSkill)) {
            $this->technicalSkills->add($technicalSkill);
            $technicalSkill->addExperience($this);
        }

        return $this;
    }

    public function removeTechnicalSkill(self $technicalSkill): static
    {
        if ($this->technicalSkills->removeElement($technicalSkill)) {
            $technicalSkill->removeExperience($this);
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
            $skillNote->setTechnicalSkill($this);
        }

        return $this;
    }

    public function removeSkillNote(SkillNote $skillNote): static
    {
        if ($this->skillNotes->removeElement($skillNote)) {
            // set the owning side to null (unless already changed)
            if ($skillNote->getTechnicalSkill() === $this) {
                $skillNote->setTechnicalSkill(null);
            }
        }

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
            $posting->addTechnicalSkill($this);
        }

        return $this;
    }

    public function removePosting(Posting $posting): static
    {
        if ($this->postings->removeElement($posting)) {
            $posting->removeTechnicalSkill($this);
        }

        return $this;
    }
}
