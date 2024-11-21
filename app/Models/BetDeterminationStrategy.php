<?php

namespace App\Models;

/**
 * Strategy to determine bet results
 */
enum BetDeterminationStrategy: string
{
    case DiffOrder = 'diff_order';
    case DiffGradient = 'diff_gradient';
    case ExactMatch = 'exact_match';
    case Manual = 'manual';
}
