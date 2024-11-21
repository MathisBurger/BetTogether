<?php

namespace App\Models;

/**
 * Policy to determine who can create a bet
 */
enum BetCreationPolicy: string
{
    case AdminOnly = 'admin';
    case Creators = 'creators';
    case Everyone = 'everyone';
}
