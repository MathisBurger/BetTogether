<?php

namespace App\Models;

enum UserRole: string
{
    case SystemAdmin = 'sys_admin';
    case Member = 'member';
}
