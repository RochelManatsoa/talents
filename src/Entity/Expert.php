<?php

namespace App\Entity;

use App\Repository\ExpertRepository;
use Doctrine\DBAL\Types\Types;
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

    #[ORM\OneToOne(inversedBy: 'expert', cascade: ['persist', 'remove'])]
    private ?Identity $identity = null;

    #[ORM\Column(length: 255)]
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

    public function setTitle(string $title): static
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
}
