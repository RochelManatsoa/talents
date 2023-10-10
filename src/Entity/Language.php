<?php

namespace App\Entity;

use App\Entity\Identity\SpokenLanguage;
use App\Repository\LanguageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LanguageRepository::class)]
class Language
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $slug = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $code = null;

    #[ORM\OneToMany(mappedBy: 'language', targetEntity: SpokenLanguage::class)]
    private Collection $languages;

    public function __construct()
    {
        $this->languages = new ArrayCollection();
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

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): static
    {
        $this->code = $code;

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
            $language->setLanguage($this);
        }

        return $this;
    }

    public function removeLanguage(SpokenLanguage $language): static
    {
        if ($this->languages->removeElement($language)) {
            // set the owning side to null (unless already changed)
            if ($language->getLanguage() === $this) {
                $language->setLanguage(null);
            }
        }

        return $this;
    }
}
