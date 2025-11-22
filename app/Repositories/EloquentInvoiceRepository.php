<?php
namespace App\Repositories;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Support\Str;
use DB;

class EloquentInvoiceRepository implements InvoiceRepositoryInterface {
    public function list(array $filters = []) {
        $query = Invoice::with('account')->latest();

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }
        if (!empty($filters['q'])) {
            $q = $filters['q'];
            $query->whereHas('account', fn($q2) => $q2->where('name','like',"%$q%")->orWhere('account_number','like',"%$q%"));
        }
        if (!empty($filters['from'])) {
            $query->whereDate('created_at','>=',$filters['from']);
        }
        if (!empty($filters['to'])) {
            $query->whereDate('created_at','<=',$filters['to']);
        }

        return $query->paginate(20);
    }

    public function find($id) {
        return Invoice::with('items','account')->findOrFail($id);
    }

    public function create(array $data) {
        return DB::transaction(function() use($data) {
            $items = $data['items'] ?? [];
            unset($data['items']);

            $data['number'] = $this->generateNumber();
            $invoice = Invoice::create($data);

            $total = 0;
            foreach ($items as $it) {
                $line_total = $it['quantity'] * $it['unit_price'];
                $invoice->items()->create([
                    'description' => $it['description'],
                    'quantity' => $it['quantity'],
                    'unit_price' => $it['unit_price'],
                    'line_total' => $line_total,
                ]);
                $total += $line_total;
            }
            $invoice->update(['amount'=>$total]);
            return $invoice->fresh('items','account');
        });
    }

    public function update($id, array $data) {
        return DB::transaction(function() use($id, $data) {
            $invoice = Invoice::findOrFail($id);
            $items = $data['items'] ?? [];
            unset($data['items']);
            $invoice->update($data);

            // naive: delete & recreate items
            $invoice->items()->delete();
            $total = 0;
            foreach ($items as $it) {
                $line_total = $it['quantity'] * $it['unit_price'];
                $invoice->items()->create([
                    'description'=>$it['description'],
                    'quantity'=>$it['quantity'],
                    'unit_price'=>$it['unit_price'],
                    'line_total'=>$line_total
                ]);
                $total += $line_total;
            }
            $invoice->update(['amount'=>$total]);
            return $invoice->fresh('items','account');
        });
    }

    public function delete($id) {
        $invoice = Invoice::findOrFail($id);
        return $invoice->delete();
    }

    protected function generateNumber() {
        // Example: INV-20251122-XXXX
        return 'INV-' . now()->format('Ymd') . '-' . strtoupper(Str::random(4));
    }
}
