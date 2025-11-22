<?php

namespace App\Http\Middleware;

use Closure;

class PortalAccess
{
    public function handle($request, Closure $next, $portal)
    {
        $user = auth()->user();

        // Billing portal → only billing_admin can access
        if ($portal === 'billing' && $user->role !== 'billing_admin') {
            abort(403, "Only Billing Admins can access Billing Portal.");
        }

        // Agency portal → all agency users allowed
        if ($portal === 'agency' && !in_array($user->role, ['agency_admin','agent','billing_admin'])) {
            abort(403);
        }

        return $next($request);
    }
}
