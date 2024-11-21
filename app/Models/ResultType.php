<?php

namespace App\Models;

/**
 * Defines the type of bet answer
 */
enum ResultType: string
{
    case String = 'string';
    case Integer = 'integer';
    case Float = 'float';
}
