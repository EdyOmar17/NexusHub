<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Website;

class WebsiteSeeder extends Seeder
{
    public function run(): void
    {
        $servers = ['Emilinku', 'Neowbcom', 'Websitet', 'Mywe'];
        $domains = ['shop', 'blog', 'admin', 'api', 'app', 'nexus', 'core', 'portal'];
        $exts = ['.com', '.net', '.io', '.sh', '.site'];

        foreach ($servers as $server) {
            for ($i = 1; $i <= 50; $i++) {

                $domain = $domains[array_rand($domains)] . '-' . strtolower($server) . '-' . sprintf('%02d', $i) . $exts[array_rand($exts)];
                
                $rand = rand(1, 100);

                // PRIORIDAD
                $priority = 'green';
                if ($rand > 90) $priority = 'red';
                else if ($rand > 70) $priority = 'yellow';

                // STATUS CORREGIDO
                $status = ($rand > 95) ? 'suspendida' : 'operativa';

                $is_hacked = ($rand > 98);
                $has_backup = ($rand > 20);

                Website::create([
                    'domain' => $domain,
                    'is_working' => ($status === 'operativa'),
                    'has_backup' => $has_backup,
                    'is_hacked' => $is_hacked,
                    'username' => 'user_' . strtolower($server) . '_' . $i,
                    'password' => bin2hex(random_bytes(4)),
                    'priority' => $priority,
                    'website_status' => $status,
                    'server_name' => $server,
                ]);
            }
        }
    }
}