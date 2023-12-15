<?php

namespace App\Dto\Event;

use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use ApiPlatform\Metadata\Post;
use App\Dto\User\Provider\UserProvider;
use App\Dto\User\Request\ResetPasswordRequest;
use App\Dto\User\Request\UserRequest;
use App\Dto\User\Response\ResetPasswordResponse;
use App\Dto\User\Response\UserResponse;
use App\Entity\UserEntity;
use App\Processor\User\ResetPasswordProcessor;

#[ApiResource(
    shortName: 'Event',
)]
#[GetCollection]
#[Get]
final class Event {}