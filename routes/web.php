<?php

use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PortalController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Switch portals
    Route::post('/portal/switch/{portal}', [PortalController::class, 'switchPortal'])
        ->name('portal.switch');

    // Agency Portal
    Route::middleware(['auth', 'portal.access:agency'])->group(function () {
        Route::get('/agency/dashboard', [PortalController::class, 'agencyDashboard'])->name('agency.dashboard');
    });

    // Billing Portal
    Route::middleware(['auth', 'portal.access:billing'])->group(function () {
        Route::get('/billing/dashboard', [PortalController::class, 'billingDashboard'])->name('billing.dashboard');
    });

    // switch by agency
    Route::post('/portal/switch-agency/{agency}', function ($agencyId, \Illuminate\Http\Request $request) {
        $user = auth()->user();

        if ($user->role !== 'billing_admin') {
            abort(403, "Only Billing Admins can switch agencies.");
        }

        $request->session()->put('switch_agency_id', $agencyId);

        return redirect()->route('agency.dashboard');
    })->name('portal.switch-agency');

    // portal switcher
    //Route::post('portal/switch/{portal}', [PortalController::class, 'switchPortal'])->name('portal.switch');

    // invoices
    Route::get('invoices', [InvoiceController::class, 'index'])->name('invoices.index');
    Route::get('invoices/create', [InvoiceController::class, 'create'])->name('invoices.create');
    Route::post('invoices', [InvoiceController::class, 'store'])->name('invoices.store');
    Route::get('invoices/{id}', [InvoiceController::class, 'show'])->name('invoices.show');
    Route::get('invoices/{id}/edit', [InvoiceController::class, 'edit'])->name('invoices.edit');
    Route::put('invoices/{id}', [InvoiceController::class, 'update'])->name('invoices.update');
    Route::delete('invoices/{id}', [InvoiceController::class, 'destroy'])->name('invoices.destroy');

    Route::post('invoices/{id}/send', [InvoiceController::class, 'markSent'])->name('invoices.send');
    Route::post('invoices/{id}/pay', [InvoiceController::class, 'markPaid'])->name('invoices.pay');
});

require __DIR__ . '/auth.php';
