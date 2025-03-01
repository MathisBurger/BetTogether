<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Illuminate\View\View;
use Parsedown;

/**
 * Controller for legal views
 */
readonly class LegalController
{
    public function impress(): View
    {
        $markdown = File::get(resource_path('markdown/impress.md'));
        $parsedown = new Parsedown;
        $htmlContent = $parsedown->text($markdown);

        // Return the parsed HTML content to a view
        return view('impress', ['impress' => $htmlContent]);
    }
}
