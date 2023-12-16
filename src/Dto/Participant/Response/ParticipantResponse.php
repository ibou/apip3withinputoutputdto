<?php

namespace App\Dto\Participant\Response;

use ApiPlatform\Metadata\ApiResource;
use App\Dto\Participant\Participant;
use App\Dto\Response;
use App\Entity\Event;
use App\Entity\User;

#[ApiResource(
    operations: [],
    routePrefix: Participant::ROUTE,
)]
class ParticipantResponse implements Response
{
    public function __construct(
        private string $uuid,
        private string $role,
        private readonly User  $user,
        private readonly Event $event,
    ){
        $this
            ->setId($uuid)
            ->setRole($role)
        ;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->uuid;
    }

    /**
     * @param string $uuid
     * @return ParticipantResponse
     */
    public function setId(string $uuid): static
    {
        $this->uuid = $uuid;
        return $this;
    }

    /**
     * @return string
     */
    public function getRole(): string
    {
        return $this->role;
    }

    /**
     * @param string $role
     * @return ParticipantResponse
     */
    public function setRole(string $role): static
    {
        $this->role = $role;
        return $this;
    }

    /**
     * @return string
     */
    public function getUserEmail(): string
    {
        return $this->user->getEmail();
    }

    public function getEventName(): string
    {
        return $this->event->getName();
    }
}