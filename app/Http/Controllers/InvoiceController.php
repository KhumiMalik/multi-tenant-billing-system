<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Repositories\InvoiceRepositoryInterface;
use App\Http\Requests\InvoiceStoreRequest;
use App\Http\Requests\InvoiceUpdateRequest;
use App\Models\Account;

class InvoiceController extends Controller {
    protected $invoices;

    public function __construct(InvoiceRepositoryInterface $invoices) {
        $this->middleware('auth');
        $this->invoices = $invoices;
    }

    public function index(Request $request) {
        $filters = $request->only(['status','q','from','to']);
        $invoices = $this->invoices->list($filters);
        return view('invoices.index', compact('invoices'));
    }

    public function create() {
        $accounts = Account::pluck('name','id');
        return view('invoices.create', compact('accounts'));
    }

    public function store(InvoiceStoreRequest $request) {
        $data = $request->validated();
        $invoice = $this->invoices->create($data);
        return redirect()->route('invoices.show', $invoice->id)->with('success','Invoice created.');
    }

    public function show($id) {
        $invoice = $this->invoices->find($id);
        return view('invoices.show', compact('invoice'));
    }

    public function edit($id) {
        $invoice = $this->invoices->find($id);
        $accounts = Account::pluck('name','id');
        return view('invoices.edit', compact('invoice','accounts'));
    }

    public function update(InvoiceUpdateRequest $request, $id) {
        $data = $request->validated();
        $invoice = $this->invoices->update($id, $data);
        return redirect()->route('invoices.show', $invoice->id)->with('success','Invoice updated.');
    }

    public function destroy($id) {
        $this->invoices->delete($id);
        return redirect()->route('invoices.index')->with('success','Invoice deleted.');
    }

    public function markSent($id) {
        $inv = $this->invoices->find($id);
        $inv->markSent();
        return redirect()->back()->with('success','Marked sent.');
    }

    public function markPaid($id) {
        $inv = $this->invoices->find($id);
        $inv->markPaid();
        return redirect()->back()->with('success','Marked paid.');
    }
}
