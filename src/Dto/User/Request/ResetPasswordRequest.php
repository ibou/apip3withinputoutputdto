<?php

namespace App\Dto\User\Request;

use Symfony\Component\Validator\Constraints as Assert;
final class ResetPasswordRequest
{
    #[Assert\Email]
    public $email;
}