<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * Controller for handling notifications
 */
readonly class NotificationsController
{
    public function notificationsView(): View
    {
        $user = User::find(Auth::id());
        /** @phpstan-ignore property.notFound */
        $notifications = $user->unreadNotifications;

        return view('notifications', ['notifications' => $notifications]);
    }

    public function markAsRead(string $id): RedirectResponse
    {
        DatabaseNotification::find($id)->markAsRead();

        return redirect()->back();
    }

    public function markAllAsRead(): RedirectResponse
    {
        $user = User::find(Auth::id());
        /** @phpstan-ignore property.notFound */
        $notifications = $user->unreadNotifications;
        $notifications->markAsRead();

        return redirect()->back();
    }
}
