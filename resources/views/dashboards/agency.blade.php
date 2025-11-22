@extends('layouts.app')

@section('content')
<h2>Agency Dashboard – {{ $agency->name }}</h2>

<h4>Your Recent Invoices</h4>

<table class="table">
    <thead>
        <tr>
            <th>#</th>
            <th>Status</th>
            <th>Amount</th>
        </tr>
    </thead>
    <tbody>
        @foreach($invoices as $invoice)
        <tr>
            <td>{{ $invoice->id }}</td>
            <td>{{ $invoice->status }}</td>
            <td>{{ $invoice->amount }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
