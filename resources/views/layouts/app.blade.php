<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bug Report App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
        <div class="container">
            {{-- Link Brand dinamis sesuai role --}}
            <a class="navbar-brand" href="
                @auth
                    @if(auth()->user()->isBugTester())
                        {{ route('bug_tester.bug-reports.index') }}
                    @elseif(auth()->user()->isDeveloper())
                        {{ route('developer.bug-reports.index') }}
                    @else
                        {{ route('bug-reports.index') }} {{-- atau route default jika ada --}}
                    @endif
                @else
                    {{ url('/') }}
                @endauth
            ">Bug Report</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                {{-- Menu kiri --}}
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    @auth
                        @if(auth()->user()->isBugTester())
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('bug_tester.bug-reports.index') }}">Dashboard Tester</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('bug_tester.bug-reports.create') }}">Laporkan Bug</a>
                            </li>
                        @elseif(auth()->user()->isDeveloper())
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('developer.bug-reports.index') }}">Dashboard Developer</a>
                            </li>
                            {{-- Bisa tambahkan menu khusus developer jika ada --}}
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('bug-reports.index') }}">Dashboard</a>
                            </li>
                        @endif
                    @endauth
                </ul>

                {{-- Menu kanan --}}
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    @guest
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Register</a></li>
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                               data-bs-toggle="dropdown" aria-expanded="false">
                                {{ auth()->user()->name }} ({{ ucfirst(auth()->user()->role) }})
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                {{-- Link Profile dihapus karena tidak diperlukan --}}
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        {{-- Flash messages --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
