<?php

namespace App\Entity;

use App\Entity\Trait\IdentifiableEntity;
use App\Repository\ParticipantRepository;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Symfony\Component\Uid\Uuid;

#[Entity(repositoryClass: ParticipantRepository::class)]
class Participant implements EntityInterface
{
    use IdentifiableEntity;

    #[ManyToOne]
    #[JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?User $User = null;

    #[ManyToOne(inversedBy: 'participants')]
    #[JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?Event $Event = null;

    #[Column(length: 255)]
    private ?string $role = null;

    public function __construct()
    {
        $this->uuid = Uuid::v6();
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): static
    {
        $this->User = $User;

        return $this;
    }

    public function getEvent(): ?Event
    {
        return $this->Event;
    }

    public function setEvent(?Event $Event): static
    {
        $this->Event = $Event;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): static
    {
        $this->role = $role;

        return $this;
    }
}
