<?php

namespace App\Dto\User\Request;

use Symfony\Component\Validator\Constraints as Assert;

final class UserRequest
{
    #[Assert\NotBlank(message: 'Uuid is required.')]
    public string $uuid;
}