<?php

namespace App\Http\Middleware;

use App\Models\Agency;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetCurrentAgency
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        // Determine current agency from logged-in user
        $agency = $user ? $user->agency : null;

        if ($agency) {
            app()->instance('currentAgency', $agency);
        }

        // Determine portal: 'agency' or 'billing' (keep session if user switched)
        $portal = $request->session()->get('portal', 'agency');
        app()->instance('currentPortal', $portal);



        // Determine agency: prefer session('agency_id'), fallback to subdomain or query param
        // $agency = null;
        // if ($request->session()->has('agency_id')) {
        //     $agency = Agency::find($request->session()->get('agency_id'));
        // } elseif ($request->has('agency')) {
        //     $agency = Agency::where('slug', $request->get('agency'))->first();
        // } else {
        //     // Optionally, parse subdomain -> slug.yourapp.com
        //     $host = $request->getHost();
        //     $parts = explode('.', $host);
        //     if (count($parts) > 2) {
        //         $sub = $parts[0];
        //         $agency = Agency::where('slug', $sub)->first();
        //     }
        // }

        // if ($agency) {
        //     app()->instance('currentAgency', $agency);
        //     // also push to session for persistence
        //     $request->session()->put('agency_id', $agency->id);
        // }

        // // portal: 'agency' or 'billing'
        // $portal = $request->session()->get('portal', 'agency');
        // app()->instance('currentPortal', $portal);

        return $next($request);
    }
}
