<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use App\Traits\TimestampTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ProjectRepository::class)]
class Project
{
    use TimestampTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["getProjects", "getContributions", "getUsers"])]
    private ?int $id = null;

    #[ORM\Column(length: 40, nullable: true)]
    #[Groups(["getProjects", "getUsers", "getContributions"])]
    private ?string $projectname = null;

    #[ORM\Column(length: 200, nullable: true)]
    #[Groups(["getProjects", "getUsers"])]
    private ?string $descripton = null;

    #[ORM\Column(nullable: true)]
    #[Groups(["getProjects", "getUsers"])]
    private ?float $goal_amount = null;

    #[ORM\Column(length: 20, nullable: true)]
    #[Groups(["getProjects", "getUsers"])]
    private ?string $statut = null;

    #[ORM\Column(nullable: true)]
    #[Groups(["getProjects"])]
    private ?float $yield = null;

    #[ORM\Column(nullable: true)]
    #[Groups(["getProjects", "getUsers"])]
    private ?int $duration = null;

    #[ORM\Column(nullable: true)]
    #[Groups(["getProjects"])]
    private ?float $current_amount = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(["getProjects", "getUsers"])]
    private ?string $projectimage = null;

    #[ORM\ManyToOne]
    #[Groups(["getProjects"])]
    private ?User $creator = null;

    #[ORM\OneToMany(targetEntity: Contribution::class, mappedBy: 'project')]
    #[Groups(["getProjects"])]
    private Collection $contributions;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(["getProjects", "getUsers"])]
    private ?\DateTimeInterface $date_start = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(["getProjects"])]
    private ?\DateTimeInterface $date_end = null;


    public function __construct()
    {
        $this->contributions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProjectname(): ?string
    {
        return $this->projectname;
    }

    public function setProjectname(?string $projectname): static
    {
        $this->projectname = $projectname;

        return $this;
    }

    public function getDescripton(): ?string
    {
        return $this->descripton;
    }

    public function setDescripton(?string $descripton): static
    {
        $this->descripton = $descripton;

        return $this;
    }

    public function getGoalAmount(): ?float
    {
        return $this->goal_amount;
    }

    public function setGoalAmount(?float $goal_amount): static
    {
        $this->goal_amount = $goal_amount;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(?string $statut): static
    {
        $this->statut = $statut;

        return $this;
    }

    public function getYield(): ?float
    {
        return $this->yield;
    }

    public function setYield(?float $yield): static
    {
        $this->yield = $yield;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(?int $duration): static
    {
        $this->duration = $duration;

        return $this;
    }

    public function getCurrentAmount(): ?float
    {
        return $this->current_amount;
    }

    public function setCurrentAmount(?float $current_amount): static
    {
        $this->current_amount = $current_amount;

        return $this;
    }

    public function getProjectimage(): ?string
    {
        return $this->projectimage;
    }

    public function setProjectimage($projectimage): static
    {
        $this->projectimage = $projectimage;

        return $this;
    }

    public function getCreator(): ?User
    {
        return $this->creator;
    }

    public function setCreator(?User $creator): static
    {
        $this->creator = $creator;

        return $this;
    }

    /**
     * @return Collection<int, Contribution>
     */
    public function getContributions(): Collection
    {
        return $this->contributions;
    }

    public function addContribution(Contribution $contribution): static
    {
        if (!$this->contributions->contains($contribution)) {
            $this->contributions->add($contribution);
            $contribution->setProject($this);
        }

        return $this;
    }

    public function removeContribution(Contribution $contribution): static
    {
        if ($this->contributions->removeElement($contribution)) {
            // set the owning side to null (unless already changed)
            if ($contribution->getProject() === $this) {
                $contribution->setProject(null);
            }
        }

        return $this;
    }

    public function getDateStart(): ?\DateTimeInterface
    {
        return $this->date_start;
    }

    public function setDateStart(?\DateTimeInterface $date_start): static
    {
        $this->date_start = $date_start;

        return $this;
    }

    public function getDateEnd(): ?\DateTimeInterface
    {
        return $this->date_end;
    }

    public function setDateEnd(?\DateTimeInterface $date_end): static
    {
        $this->date_end = $date_end;

        return $this;
    }
}
