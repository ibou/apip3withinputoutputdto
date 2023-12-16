<?php

namespace App\Dto\Participant;

use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use App\Dto\Participant\Response\ParticipantResponse;
use App\Entity\Participant as ParticipantEntity;
use App\Provider\Provider;

#[ApiResource(
    shortName: 'Participant',
    output: ParticipantResponse::class,
    provider: Provider::class,
    stateOptions: new Options(entityClass: ParticipantEntity::class)
)]
#[GetCollection(
    uriTemplate: '/' . self::ROUTE,
    paginationItemsPerPage: 30,
    paginationClientEnabled: true,
    paginationClientItemsPerPage: true,
)]
#[Get(
    uriTemplate: '/' . self::ROUTE . '/{id}',
    uriVariables: [
        'id' => new Link(fromClass: ParticipantEntity::class, identifiers: ['uuid']),
    ],
    requirements: [
        'uuid' => '^[a-f0-9]{8}-([a-f0-9]{4}-){3}[a-f0-9]{12}$'
    ],
)]
class Participant
{
    public const ROUTE = 'participants';
}