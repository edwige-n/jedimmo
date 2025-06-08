<?php

namespace App\Entity;

use App\Repository\UserRepository;
use App\Traits\TimestampTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\Ignore;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    use TimestampTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["getProjects", "getContributions", "getUsers"])]
    private ?int $id = null;

    #[ORM\Column(length: 40, nullable: true)]
    #[Groups(["getProjects", "getContributions", "getUsers"])]
    private ?string $lastname = null;

    #[ORM\Column(length: 40, nullable: true)]
    #[Groups(["getProjects", "getContributions", "getUsers"])]
    private ?string $firstname = null;

    #[ORM\Column(length: 140, nullable: true)]
    #[Groups(["getProjects", "getContributions", "getUsers"])]
    private ?string $email = null;

    #[ORM\Column(length: 20, nullable: true)]
    #[Groups(["getProjects" , "getContributions", "getUsers"])]
    private ?string $statut = null;

    #[ORM\Column(length: 70, nullable: true)]
    #[Groups(["getProjects", "getContributions", "getUsers"])]
    private ?string $profile_pic = null;

    #[ORM\OneToMany(targetEntity: Project::class, mappedBy: 'creator')]
    #[Groups(["getUsers"])]
    private Collection $projects;

    #[ORM\OneToMany(targetEntity: Contribution::class, mappedBy: 'contributor')]
    #[Groups(["getUsers"])]
    private Collection $contributions;

    #[ORM\Column(length: 90, nullable: true)]
    #[Ignore]
    private ?string $password = null;

    #[ORM\Column(nullable: true)]
    #[Ignore]
    private ?array $roles = null;

    /**
     * @var Collection<int, Watchlist>
     */
    #[ORM\OneToMany(targetEntity: Watchlist::class, mappedBy: 'user')]
    #[Groups("getUsers")]
    private Collection $watchlists;


    public function __construct()
    {
        $this->projects = new ArrayCollection();
        $this->contributions = new ArrayCollection();
        $this->watchlists = new ArrayCollection();
       
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(?string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(?string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

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

    public function getProfilePic()
    {
        return $this->profile_pic;
    }

    public function setProfilePic($profile_pic): static
    {
        $this->profile_pic = $profile_pic;

        return $this;
    }

    /**
     * @return Collection<int, Project>
     */
    public function getProjects(): Collection
    {
        return $this->projects;
    }

    public function addProject(Project $project): static
    {
        if (!$this->projects->contains($project)) {
            $this->projects->add($project);
            $project->setCreator($this);
        }

        return $this;
    }

    public function removeProject(Project $project): static
    {
        if ($this->projects->removeElement($project)) {
            // set the owning side to null (unless already changed)
            if ($project->getProjectname() === $this) {
                $project->setProjectname(null);
            }
        }

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
            $contribution->setContributor($this);
        }

        return $this;
    }

    public function removeContribution(Contribution $contribution): static
    {
        if ($this->contributions->removeElement($contribution)) {
            // set the owning side to null (unless already changed)
            if ($contribution->getContributor() === $this) {
                $contribution->setContributor(null);
            }
        }

        return $this;
    }


    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

  
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    public function setRoles(?array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }


    public function eraseCredentials(): void
    {
        // TODO: Implement eraseCredentials() method.
    }

    /**
     * @return Collection<int, Watchlist>
     */
    public function getWatchlists(): Collection
    {
        return $this->watchlists;
    }

    public function addWatchlist(Watchlist $watchlist): static
    {
        if (!$this->watchlists->contains($watchlist)) {
            $this->watchlists->add($watchlist);
            $watchlist->setUser($this);
        }

        return $this;
    }

    public function removeWatchlist(Watchlist $watchlist): static
    {
        if ($this->watchlists->removeElement($watchlist)) {
            // set the owning side to null (unless already changed)
            if ($watchlist->getUser() === $this) {
                $watchlist->setUser(null);
            }
        }

        return $this;
    }

}
