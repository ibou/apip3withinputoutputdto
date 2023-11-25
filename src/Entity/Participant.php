<?php

namespace App\Entity;

use App\Entity\Trait\IdentifiableEntity;
use App\Repository\ParticipantRepository;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;

#[Entity(repositoryClass: ParticipantRepository::class)]
class Participant
{
    use IdentifiableEntity;

    #[ManyToOne(targetEntity: User::class)]
    #[JoinColumn(name: 'user_id', referencedColumnName: 'id')]
    private int $user_id;

    #[ManyToOne(targetEntity: Event::class)]
    #[JoinColumn(name: 'event_id', referencedColumnName: 'id')]
    private int $event_id;
}