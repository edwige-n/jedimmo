<?php

namespace App\Entity;

use App\Repository\ContributionRepository;
use App\Traits\TimestampTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups; 

#[ORM\Entity(repositoryClass: ContributionRepository::class)]
class Contribution
{
    use TimestampTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["getContributions", "getUsers"])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'contributions')]
    #[Groups(["getContributions"])]
    private ?User $contributor = null;

    #[ORM\ManyToOne(inversedBy: 'contributions')]
    #[Groups(["getContributions", "getUsers"])]
    private ?Project $project = null;

    #[ORM\Column(nullable: true)]
    #[Groups(["getContributions", "getUsers"])]
    private ?float $amount = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContributor(): ?User
    {
        return $this->contributor;
    }

    public function setContributor(?User $contributor): static
    {
        $this->contributor = $contributor;

        return $this;
    }

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(?Project $project): static
    {
        $this->project = $project;

        return $this;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(?float $amount): static
    {
        $this->amount = $amount;

        return $this;
    }
}
