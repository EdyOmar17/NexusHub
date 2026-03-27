<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Website;
use App\Models\UptimeHistory;
use Illuminate\Support\Facades\Http;
use App\Events\WebsiteStatusChanged;

class MonitorWebsites extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'websites:monitor';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pings websites and updates their status in the DB in real-time.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $websites = Website::where('is_maintenance', false)->get();

        foreach ($websites as $website) {
            $url = str_starts_with($website->domain, 'http') ? $website->domain : 'https://' . $website->domain;
            try {
                $response = Http::timeout(10)->get($url);
                $isWorking = $response->successful();
            } catch (\Exception $e) {
                // Try http if https fails and domain didn't explicitly have a protocol
                if (!str_starts_with($website->domain, 'http') && str_starts_with($url, 'https')) {
                    try {
                        $response = Http::timeout(10)->get('http://' . $website->domain);
                        $isWorking = $response->successful();
                    } catch (\Exception $e2) {
                        $isWorking = false;
                    }
                } else {
                    $isWorking = false;
                }
            }

            $newStatus = $isWorking ? 'operativa' : 'suspendida';

            if ($website->website_status !== $newStatus) {
                $website->update([
                    'website_status' => $newStatus,
                    'is_working' => $isWorking
                ]);

                // Fire event
                broadcast(new WebsiteStatusChanged($website));
                
                $users = \App\Models\User::all();
                \Illuminate\Support\Facades\Notification::send($users, new \App\Notifications\WebsiteStatusNotification($website, $newStatus));
                $this->info("Status changed for {$website->domain} to {$newStatus}");
            }
        }

        // Record global uptime history
        $total = Website::count();
        $online = Website::where('website_status', 'operativa')->count();
        $percentage = $total > 0 ? ($online / $total) * 100 : 100;

        UptimeHistory::create([
            'uptime_percentage' => $percentage,
            'total_sites' => $total,
            'online_sites' => $online,
        ]);

        $this->info("Global uptime recorded: {$percentage}%");
    }
}
