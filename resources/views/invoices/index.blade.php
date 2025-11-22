@extends('layouts.app')

@section('content')
<h3>Invoices</h3>

<form class="row g-2 mb-3">
  <div class="col-auto"><input name="q" value="{{ request('q') }}" class="form-control" placeholder="search account or number"></div>
  <div class="col-auto">
    <select name="status" class="form-select">
      <option value="">All statuses</option>
      <option {{ request('status')=='pending'?'selected':'' }} value="pending">Pending</option>
      <option {{ request('status')=='sent'?'selected':'' }} value="sent">Sent</option>
      <option {{ request('status')=='paid'?'selected':'' }} value="paid">Paid</option>
    </select>
  </div>
  <div class="col-auto"><button class="btn btn-primary">Filter</button></div>
</form>

<table class="table table-sm">
  <thead>
    <tr>
      <th>Number</th>
      <th>Account</th>
      <th>Amount</th>
      <th>Status</th>
      <th>Due</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    @foreach($invoices as $inv)
      <tr>
        <td><a href="{{ route('invoices.show', $inv->id) }}">{{ $inv->number }}</a></td>
        <td>{{ $inv->account->name ?? '—' }}</td>
        <td>{{ number_format($inv->amount,2) }}</td>
        <td>{{ ucfirst($inv->status) }}</td>
        <td>{{ optional($inv->due_date)->toDateString() }}</td>
        <td>
          <a href="{{ route('invoices.edit', $inv->id) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
        </td>
      </tr>
    @endforeach
  </tbody>
</table>

{{ $invoices->withQueryString()->links() }}
@endsection
