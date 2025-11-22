<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use App\Models\Invoice;
use Illuminate\Http\Request;

class PortalController extends Controller
{
    public function switchPortal(Request $request, $portal)
    {
        if (!in_array($portal, ['agency', 'billing'])) {
            abort(404);
        }

        // only billing admins can enter billing portal
        if ($portal === 'billing' && auth()->user()->role !== 'billing_admin') {
            abort(403, "You are not allowed to enter the Billing Portal.");
        }

        $request->session()->put('portal', $portal);

        if ($portal === 'billing') {
            return redirect()->route('billing.dashboard');
        }

        return redirect()->route('agency.dashboard');
    }

    /**
     * Agency Portal Dashboard (Agency Admin, Agents)
     */
    public function agencyDashboard(Request $request)
    {
        $user = auth()->user();

        // Default: agency user sees their own agency
        if ($user->role !== 'billing_admin') {
            $agency = $user->agency;
            $invoices = $agency->invoices()->latest()->limit(10)->get();
        } else {
            // Billing admin: can view any agency by session key
            $agencyId = $request->session()->get('switch_agency_id');

            if ($agencyId) {
                $agency = Agency::find($agencyId);
            } else {
                // fallback: pick first agency
                $agency = Agency::first();
            }

            $invoices = $agency ? $agency->invoices()->latest()->limit(10)->get() : collect();
        }

        return view('dashboards.agency', compact('agency', 'invoices'));
    }

    /**
     * Billing Portal Dashboard (Billing Admin Only)
     */
    public function billingDashboard()
    {
        // Load summary for billing admin
        $agencies = Agency::withCount('invoices')->get();

        $recentInvoices = Invoice::with('agency')->latest()->limit(10)->get();

        return view('dashboards.billing', compact('agencies', 'recentInvoices'));
    }
}
