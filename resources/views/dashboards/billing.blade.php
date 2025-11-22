@extends('layouts.app')

@section('content')
    <h2>Billing Admin Dashboard</h2>

    <h4>Agencies</h4>

    <table class="table">
        <thead>
            <tr>
                <th>Agency</th>
                <th>Total Invoices</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($agencies as $agency)
                <tr>
                    <td>{{ $agency->name }}</td>
                    <td>{{ $agency->invoices_count }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h4>Recent Invoices</h4>
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Agency</th>
                <th>Status</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($recentInvoices as $invoice)
                <tr>
                    <td>{{ $invoice->id }}</td>
                    <td>{{ optional($invoice->agency)->name ?? 'N/A' }}</td>
                    <td>{{ $invoice->status }}</td>
                    <td>{{ $invoice->amount }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
