<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

/**
 * General purpose notification for the frontend
 */
class FrontendNotification extends Notification
{
    use Queueable;

    private string $link;

    private string $message;

    public function __construct(string $link, string $message)
    {
        $this->link = $link;
        $this->message = $message;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'link' => $this->link,
            'message' => $this->message,
        ];
    }
}
