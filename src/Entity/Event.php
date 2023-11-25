<?php

namespace App\Entity;

use App\Entity\Trait\IdentifiableEntity;
use App\Repository\EventRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EventRepository::class)]
class Event
{
    use IdentifiableEntity;

    #[ORM\Column(type: Types::TEXT, length: 180)]
    private string $name;
}