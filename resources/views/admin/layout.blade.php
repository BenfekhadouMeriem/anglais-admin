<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin - @yield('title')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <nav class="bg-dark text-white p-3" style="width: 250px; height: 100vh;">
            <h3>Admin Panel</h3>
            <ul class="nav flex-column">
                <li class="nav-item"><a href="{{ route('dashboard') }}" class="nav-link text-white">Dashboard</a></li>
                <li class="nav-item"><a href="{{ route('admin.podcasts.index') }}" class="nav-link text-white">Gestion des Podcasts</a></li>
                <li class="nav-item"><a href="{{ route('admin.payments.index') }}" class="nav-link text-white">Gestion des Paiements</a></li>
                <li class="nav-item">
                    <a href="{{ route('logout') }}" 
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
                       class="nav-link text-white">
                        Déconnexion
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </nav>

        <!-- Contenu principal -->
        <div class="p-4" style="flex-grow: 1;">
            @yield('content')
        </div>
    </div>
</body>
</html>
