<?php

namespace App\Enums;

enum UserRole: string
{
    case ADMIN = 'admin';
    case TRADESMAN = 'tradesman';
    case USER = 'user';
}
