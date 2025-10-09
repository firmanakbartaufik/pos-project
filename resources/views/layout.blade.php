<!DOCTYPE html>
<html>
<head>
    <title>POS System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="/">POS Laravel</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarMenu">
            <ul class="navbar-nav ms-auto">

                {{-- Jika belum login --}}
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                @endguest

                {{-- Jika sudah login --}}
                @auth
                    {{-- Role: Admin --}}
                    @if (Auth::user()->role->name === 'admin')
                        <li class="nav-item"><a href="/products" class="nav-link">Produk</a></li>
                        <li class="nav-item"><a href="/transactions" class="nav-link">Transaksi</a></li>
                        <li class="nav-item"><a href="/transactions/report" class="nav-link">Laporan</a></li>
                        <li class="nav-item"><a href="/settings" class="nav-link">Setting</a></li>
                        <li class="nav-item"><a href="/users" class="nav-link">Users Management</a></li>

                    {{-- Role: Kasir --}}
                    @elseif (Auth::user()->role->name === 'kasir')
                        <li class="nav-item"><a href="/products" class="nav-link">Produk</a></li>
                        <li class="nav-item"><a href="/transactions" class="nav-link">Transaksi</a></li>
                        <li class="nav-item"><a href="/transactions/report" class="nav-link">Laporan</a></li>
                    @endif

                    {{-- Dropdown User --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdown"
                           role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            👤 {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li><span class="dropdown-item-text">Role: {{ Auth::user()->role->name }}</span></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
