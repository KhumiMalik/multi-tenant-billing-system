<!doctype html>
<html>

<head>
    <title>Mini Billing System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <span class="navbar-brand">Mini Billing</span>

            <div class="d-flex">

                @auth
                    {{-- Current Portal Label --}}
                    <span class="badge bg-info me-2">
                        {{ strtoupper(session('portal', 'agency')) }} PORTAL
                    </span>

                    <a class="btn btn-sm btn-success" href="{{ route('invoices.create') }}">New Invoice</a>

                    {{-- Switch to Agency Portal if user belongs to an agency --}}
                    @if (auth()->user()->agency)
                        <form method="POST" action="{{ route('portal.switch', 'agency') }}" class="me-2">
                            @csrf
                            <button class="btn btn-sm btn-outline-light">Agency Portal</button>
                        </form>
                    @endif

                    {{-- Switch to Billing Portal if billing admin --}}
                    @if (auth()->user()->role === 'billing_admin')
                        <form method="POST" action="{{ route('portal.switch-agency', 0) }}" id="switch-agency-form">
                            @csrf
                            <select name="agency_id" id="agency_id" class="form-select"
                                onchange="document.getElementById('switch-agency-form').action='/portal/switch-agency/'+this.value; this.form.submit();">
                                <option value="">-- Switch to Agency --</option>
                                @foreach (\App\Models\Agency::all() as $agency)
                                    <option value="{{ $agency->id }}"
                                        {{ session('switch_agency_id') == $agency->id ? 'selected' : '' }}>
                                        {{ $agency->name }}
                                    </option>
                                @endforeach
                            </select>
                        </form>
                    @endif

                    {{-- Logout --}}
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn btn-sm btn-danger">Logout</button>
                    </form>
                @endauth

                @guest
                    <a href="{{ route('login') }}" class="btn btn-sm btn-outline-primary me-2">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-sm btn-outline-secondary">Register</a>
                @endguest

            </div>
        </div>
    </nav>

    <div class="container mt-4">
        @yield('content')
    </div>

</body>

</html>
