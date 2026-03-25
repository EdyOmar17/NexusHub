<?php

namespace App\Notifications;

use App\Models\Website;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class WebsiteStatusNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $website;
    public $status;

    public function __construct(Website $website, string $status)
    {
        $this->website = $website;
        $this->status = $status;
    }

    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'website_id' => $this->website->id,
            'domain' => $this->website->domain,
            'status' => $this->status,
        ];
    }

    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'website_id' => $this->website->id,
            'domain' => $this->website->domain,
            'status' => $this->status,
        ]);
    }
}
