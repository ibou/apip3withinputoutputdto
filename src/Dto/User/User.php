<?php

namespace App\Dto\User;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use ApiPlatform\Metadata\Post;
use App\Dto\User\Request\ResetPasswordRequest;
use App\Dto\User\Request\UserRequest;
use App\Dto\User\Response\ResetPasswordResponse;
use App\Dto\User\Response\UserCollectionResponse;
use App\Dto\User\Response\UserResponse;
use App\Entity\User as UserEntity;
use App\Processor\User\ResetPasswordProcessor;
use App\Provider\Provider;

#[ApiResource(
    shortName: 'User',
    input: UserRequest::class,
    provider: Provider::class,
    stateOptions: new Options(entityClass: UserEntity::class)
)]
#[ApiFilter(
    SearchFilter::class,
    properties: [
        'email' => 'partial',
    ]
)]
#[GetCollection(
    uriTemplate: '/' . self::ROUTE,
    paginationItemsPerPage: 30,
    paginationClientEnabled: true,
    paginationClientItemsPerPage: true,
    output: UserCollectionResponse::class,
)]
#[Get(
    uriTemplate: '/' . self::ROUTE . '/{id}',
    uriVariables: [
        'id' => new Link(fromClass: UserEntity::class, identifiers: ['uuid']),
    ],
    requirements: [
        'uuid' => '^[a-f0-9]{8}-([a-f0-9]{4}-){3}[a-f0-9]{12}$'
    ],
    output: UserResponse::class,
)]
#[Post(
    uriTemplate: '/reset-password',
    input: ResetPasswordRequest::class,
    output: ResetPasswordResponse::class,
    processor: ResetPasswordProcessor::class,
)]
final class User {
    public const ROUTE = 'users';
}