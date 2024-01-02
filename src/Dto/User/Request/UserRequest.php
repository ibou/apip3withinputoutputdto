<?php

namespace App\Dto\User\Request;

use Symfony\Component\Validator\Constraints as Assert;

class UserRequest
{
    #[Assert\Email]
    public string $email;

    /**
     * todo: Add all fields which are required for creating a user.
     */
}