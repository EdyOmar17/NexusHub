<?php

namespace App\Http\Controllers;

use App\Models\Website;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class WebsiteController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'domain' => 'required|string|max:255',
            'server_name' => 'required|string|in:Emilinku,Neowbcom,Websitet,Mywe',
            'username' => 'nullable|string|max:255',
            'password' => 'nullable|string|max:255',
            'priority' => 'required|in:red,yellow,green',
            'website_status' => 'required|in:operativa,suspendida',
            'hacked_description' => 'nullable|string',
        ]);

        $website = Website::create([
            'domain' => $validated['domain'],
            'server_name' => $validated['server_name'],
            'username' => $validated['username'],
            'password' => $validated['password'],
            'priority' => $validated['priority'],
            'website_status' => $validated['website_status'],
            'has_backup' => $request->has('has_backup'),
            'is_hacked' => $request->has('is_hacked'),
            'hacked_description' => $request->has('is_hacked') ? $validated['hacked_description'] : null,
            'is_working' => ($validated['website_status'] === 'operativa'),
            'is_maintenance' => $request->has('is_maintenance'),
        ]);

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'create_website',
            'description' => "Creó el sitio web: {$website->domain}",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'metadata' => ['website_id' => $website->id]
        ]);

        return redirect()->back()->with('success', 'Sitio web creado correctamente.');
    }

    public function update(Request $request, Website $website)
    {
        $validated = $request->validate([
            'domain' => 'required|string|max:255',
            'server_name' => 'required|string|in:Emilinku,Neowbcom,Websitet,Mywe',
            'username' => 'nullable|string|max:255',
            'password' => 'nullable|string|max:255',
            'priority' => 'required|in:red,yellow,green',
            'website_status' => 'required|in:operativa,suspendida',
            'hacked_description' => 'nullable|string',
        ]);

        $website->update([
            'domain' => $validated['domain'],
            'server_name' => $validated['server_name'],
            'username' => $validated['username'],
            'password' => $validated['password'],
            'priority' => $validated['priority'],
            'website_status' => $validated['website_status'],
            'has_backup' => $request->has('has_backup'),
            'is_hacked' => $request->has('is_hacked'),
            'hacked_description' => $request->has('is_hacked') ? $validated['hacked_description'] : null,
            'is_working' => ($validated['website_status'] === 'operativa'),
            'is_maintenance' => $request->has('is_maintenance'),
        ]);

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'update_website',
            'description' => "Actualizó el sitio web: {$website->domain}",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'metadata' => ['website_id' => $website->id]
        ]);

        return redirect()->back()->with('success', 'Sitio web actualizado correctamente.');
    }

    public function destroy(Website $website, Request $request)
    {
        $domain = $website->domain;
        $website->delete();

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'delete_website',
            'description' => "Eliminó el sitio web: {$domain}",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);

        return redirect()->back()->with('success', 'Sitio web eliminado correctamente.');
    }
}
