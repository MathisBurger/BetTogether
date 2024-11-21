<?php

namespace App\Models;

/**
 * User role
 */
enum UserRole: string
{
    case SystemAdmin = 'sys_admin';
    case Member = 'member';
}
