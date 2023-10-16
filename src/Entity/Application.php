<?php

namespace App\Entity;

use App\Repository\ApplicationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ApplicationRepository::class)]
class Application
{
    const STATUS_PENDING = 'PENDING';
    const STATUS_ACCEPTED = 'ACCEPTED';
    const STATUS_REJECTED = 'REJECTED';
    const STATUS_EXPIRED = 'EXPIRED';
    const STATUS_ARCHIVED = 'ARCHIVED';
    const STATUS_FINISHED = 'FINISHED';


    public static function getStatuses() {
        return [
            'En cours de négotiation' => self::STATUS_PENDING ,
            'Acceptées' => self::STATUS_ACCEPTED ,
            'Non retenus' => self::STATUS_REJECTED ,
            'Expirée' => self::STATUS_EXPIRED ,
            'Archivée' => self::STATUS_ARCHIVED ,
            'Terminée' => self::STATUS_FINISHED ,
        ];
    }

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\ManyToOne(inversedBy: 'applications')]
    private ?Posting $posting = null;

    #[ORM\ManyToOne(inversedBy: 'applications')]
    private ?Identity $identity = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $other = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $motivation = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $status = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getPosting(): ?Posting
    {
        return $this->posting;
    }

    public function setPosting(?Posting $posting): static
    {
        $this->posting = $posting;

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

    public function getOther(): ?string
    {
        return $this->other;
    }

    public function setOther(?string $other): static
    {
        $this->other = $other;

        return $this;
    }

    public function getMotivation(): ?string
    {
        return $this->motivation;
    }

    public function setMotivation(string $motivation): static
    {
        $this->motivation = $motivation;

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
}
