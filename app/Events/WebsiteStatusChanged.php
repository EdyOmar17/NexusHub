<?php

namespace App\Events;

use App\Models\Website;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class WebsiteStatusChanged implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $website;

    public function __construct(Website $website)
    {
        $this->website = $website;
    }

    public function broadcastOn(): array
    {
        return [
            new Channel('websites-status'),
        ];
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->website->id,
            'status' => $this->website->website_status,
            'domain' => $this->website->domain,
        ];
    }
}
