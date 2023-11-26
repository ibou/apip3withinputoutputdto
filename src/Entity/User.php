<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Entity\Trait\IdentifiableEntity;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\OneToMany;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Uid\Uuid;

#[Entity(repositoryClass: UserRepository::class)]
#[ApiResource(
    operations: [
        new Get(),
        new GetCollection(),
        new Post(),
        new Delete(),
    ]
)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    use IdentifiableEntity;

    #[Column(length: 180, unique: true)]
    private ?string $email = null;

    #[Column]
    private array $roles = [];

    /**
     * @var string|null The hashed password
     */
    #[Column]
    private ?string $password = null;

    public function __construct(
        string $email,
    )
    {
        $this->uuid = Uuid::v6();
        $this->setEmail($email);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

//    /**
//     * @return Collection<int, Participant>
//     */
//    public function getParticipants(): Collection
//    {
//        return $this->participants;
//    }
//
//    public function addParticipant(Participant $participant): static
//    {
//        if (!$this->participants->contains($participant)) {
//            $this->participants->add($participant);
//            $participant->setUser($this);
//        }
//
//        return $this;
//    }
//
//    public function removeParticipant(Participant $participant): static
//    {
//        if ($this->participants->removeElement($participant)) {
//            // set the owning side to null (unless already changed)
//            if ($participant->getUser() === $this) {
//                $participant->setUser(null);
//            }
//        }
//
//        return $this;
//    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
}
