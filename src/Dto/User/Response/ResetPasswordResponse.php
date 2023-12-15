<?php

namespace App\Dto\User\Response;

use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use App\Dto\User\Provider\UserProvider;
use App\Dto\User\Request\ResetPasswordRequest;
use App\Dto\User\Request\UserRequest;
use App\Entity\UserEntity;
use App\Processor\User\ResetPasswordProcessor;

#[ApiResource(
    input: UserRequest::class,
    provider: UserProvider::class,
    stateOptions: new Options(entityClass: UserEntity::class),
)]
#[Post(
    uriTemplate: '/reset-password',
    input: ResetPasswordRequest::class,
    processor: ResetPasswordProcessor::class,
)]
class ResetPasswordResponse
{

}