<?php

namespace App\Dto\User;

use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use ApiPlatform\Metadata\Post;
use App\Dto\User\Provider\UserProvider;
use App\Dto\User\Request\UserRequest;
use App\Dto\User\Request\ResetPasswordRequest;
use App\Dto\User\Response\ResetPasswordResponse;
use App\Dto\User\Response\UserCollectionResponse;
use App\Dto\User\Response\UserResponse;
use App\Entity\UserEntity;
use App\Processor\User\ResetPasswordProcessor;

#[ApiResource(
    shortName: 'User',
    provider: UserProvider::class,
    stateOptions: new Options(entityClass: UserEntity::class)
)]
#[GetCollection(
    uriTemplate: '/users',
    paginationItemsPerPage: 5,
    paginationClientEnabled: true,
    paginationClientItemsPerPage: true,
    output: UserCollectionResponse::class,
)]
#[Get(
    uriTemplate: '/users/{id}',
    uriVariables: [
        'id' => new Link(fromClass: UserEntity::class, identifiers: ['uuid']),
    ],
    requirements: [
        'uuid' => '^[a-f0-9]{8}-([a-f0-9]{4}-){3}[a-f0-9]{12}$'
    ],
    input: UserRequest::class,
    output: UserResponse::class,
)]
#[Post(
    uriTemplate: '/reset-password',
    input: ResetPasswordRequest::class,
    output: ResetPasswordResponse::class,
    processor: ResetPasswordProcessor::class,
)]
final class User {
    public const ROUTE_PREFIX = 'users';
}