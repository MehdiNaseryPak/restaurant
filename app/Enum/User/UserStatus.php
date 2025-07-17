<?php

namespace App\Enum\User;

enum UserStatus: int
{
    case Inactive = 0;
    case Active = 1;
}
