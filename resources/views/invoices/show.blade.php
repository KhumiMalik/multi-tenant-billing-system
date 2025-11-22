@extends('layouts.app')

@section('content')
<h3>Invoice {{ $invoice->number }}</h3>

<p><strong>Account:</strong> {{ $invoice->account->name }}</p>
<p><strong>Status:</strong> {{ ucfirst($invoice->status) }}</p>
<p><strong>Amount:</strong> {{ number_format($invoice->amount,2) }}</p>

<h5>Items</h5>
<table class="table table-sm">
  <thead><tr><th>Description</th><th>Qty</th><th>Unit</th><th>Total</th></tr></thead>
  <tbody>
    @foreach($invoice->items as $it)
      <tr>
        <td>{{ $it->description }}</td>
        <td>{{ $it->quantity }}</td>
        <td>{{ number_format($it->unit_price,2) }}</td>
        <td>{{ number_format($it->line_total,2) }}</td>
      </tr>
    @endforeach
  </tbody>
</table>

<form method="POST" action="{{ route('invoices.send', $invoice->id) }}" style="display:inline">
  @csrf
  <button class="btn btn-outline-primary" {{ $invoice->status!='pending'?'disabled':'' }}>Mark Sent</button>
</form>

<form method="POST" action="{{ route('invoices.pay', $invoice->id) }}" style="display:inline">
  @csrf
  <button class="btn btn-success" {{ $invoice->status=='paid'?'disabled':'' }}>Mark Paid</button>
</form>

<a href="{{ route('invoices.index') }}" class="btn btn-link">Back</a>
@endsection
