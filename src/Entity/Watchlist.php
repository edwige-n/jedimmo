<?php

namespace App\Entity;

use App\Repository\WatchlistRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups; 

#[ORM\Entity(repositoryClass: WatchlistRepository::class)]
class Watchlist
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups("getWatchlist")]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[Groups("getWatchlist")]
    private ?Project $project = null;

    #[ORM\ManyToOne(inversedBy: 'watchlists')]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }
}
