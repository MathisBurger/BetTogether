<?php

namespace App\Models;

/**
 * Strategy to determine bet results
 */
enum BetDeterminationStrategy: string
{
    case DiffGradient = 'diff_gradient';
    case ExactMatch = 'exact_match';
    case Manual = 'manual';
}
