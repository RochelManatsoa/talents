<?php

namespace App\Entity\Note;

use App\Entity\Identity;
use App\Entity\Identity\TechnicalSkill;
use App\Repository\Note\SkillNoteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SkillNoteRepository::class)]
class SkillNote
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $note = null;

    #[ORM\ManyToOne(inversedBy: 'skillNotes')]
    private ?Identity $identity = null;

    #[ORM\ManyToOne(inversedBy: 'skillNotes')]
    private ?TechnicalSkill $technicalSkill = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(int $note): static
    {
        $this->note = $note;

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

    public function getTechnicalSkill(): ?TechnicalSkill
    {
        return $this->technicalSkill;
    }

    public function setTechnicalSkill(?TechnicalSkill $technicalSkill): static
    {
        $this->technicalSkill = $technicalSkill;

        return $this;
    }
}
