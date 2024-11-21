<?php

namespace App\Models;

/**
 * Policy definitions to join a community
 */
enum CommunityJoinPolicy: string
{
    case Open = 'open';
    case Closed = 'closed';
    case Request = 'request';
}
