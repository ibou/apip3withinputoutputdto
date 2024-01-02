<?php

namespace App\Dto\Event;

use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use App\Dto\Event\Response\EventResponse;
use App\Entity\Event as EventEntity;
use App\Provider\Provider;

#[ApiResource(
    shortName: 'Event',
    output: EventResponse::class,
    provider: Provider::class,
    stateOptions: new Options(entityClass: EventEntity::class)
)]
#[GetCollection(
    uriTemplate: '/' . self::ROUTE,
    paginationItemsPerPage: 10,
    paginationClientEnabled: true,
    paginationClientItemsPerPage: true,
)]
#[Get(
    uriTemplate: '/' . self::ROUTE . '/{id}',
    uriVariables: [
        'id' => new Link(fromClass: EventEntity::class, identifiers: ['uuid']),
    ],
    requirements: [
        'uuid' => '^[a-f0-9]{8}-([a-f0-9]{4}-){3}[a-f0-9]{12}$'
    ],
)]
class Event
{
    public const ROUTE = 'events';
}