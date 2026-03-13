<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>🏨 Gestion Hôtel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        * { box-sizing: border-box; }
        body {
            background-color: #f4f6f9;
            color: #1a1d23;
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
        }

        /* SIDEBAR */
        .sidebar {
            width: 240px;
            min-height: 100vh;
            background: #ffffff;
            border-right: 1px solid #e8ecf0;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 100;
            display: flex;
            flex-direction: column;
            padding: 0;
        }
        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 20px 24px;
            border-bottom: 1px solid #e8ecf0;
        }
        .sidebar-brand-icon {
            width: 36px;
            height: 36px;
            background: #1a56db;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1rem;
        }
        .sidebar-brand-text { font-weight: 700; font-size: 1rem; color: #1a1d23; }
        .sidebar-brand-sub { font-size: 0.65rem; color: #6b7280; text-transform: uppercase; letter-spacing: 1px; }
        .sidebar-section {
            padding: 20px 16px 8px;
            font-size: 0.7rem;
            font-weight: 700;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: 1.5px;
        }
        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 16px;
            margin: 2px 8px;
            border-radius: 8px;
            color: #6b7280;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.2s;
        }
        .sidebar-link:hover { background: #f3f4f6; color: #1a1d23; }
        .sidebar-link.active { background: #eff6ff; color: #1a56db; font-weight: 600; }
        .sidebar-link .icon { font-size: 1.1rem; width: 20px; text-align: center; }
        .sidebar-footer {
            margin-top: auto;
            padding: 16px;
            border-top: 1px solid #e8ecf0;
        }
        .sidebar-user {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .sidebar-avatar {
            width: 36px;
            height: 36px;
            background: #1a56db;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 0.85rem;
        }
        .sidebar-user-name { font-weight: 600; font-size: 0.85rem; color: #1a1d23; }
        .sidebar-user-role { font-size: 0.7rem; color: #9ca3af; }

        /* TOPBAR */
        .topbar {
            position: fixed;
            top: 0;
            left: 240px;
            right: 0;
            height: 64px;
            background: #ffffff;
            border-bottom: 1px solid #e8ecf0;
            z-index: 99;
            display: flex;
            align-items: center;
            padding: 0 24px;
            gap: 16px;
        }
        .topbar-search {
            flex: 1;
            max-width: 400px;
            position: relative;
        }
        .topbar-search input {
            width: 100%;
            padding: 8px 16px 8px 40px;
            border: 1px solid #e8ecf0;
            border-radius: 8px;
            background: #f9fafb;
            font-size: 0.875rem;
            color: #1a1d23;
            outline: none;
        }
        .topbar-search input:focus { border-color: #1a56db; background: white; }
        .topbar-search-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
        }
        .topbar-actions { display: flex; align-items: center; gap: 12px; margin-left: auto; }
        .btn-new-booking {
            background: #1a56db;
            color: white;
            border: none;
            padding: 8px 18px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.875rem;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: background 0.2s;
        }
        .btn-new-booking:hover { background: #1447c0; color: white; }

        /* MAIN CONTENT */
        .main-content {
            margin-left: 240px;
            margin-top: 64px;
            padding: 28px;
            min-height: calc(100vh - 64px);
        }

        /* CARDS */
        .card {
            background: #ffffff;
            border: 1px solid #e8ecf0;
            border-radius: 12px !important;
            box-shadow: 0 1px 3px rgba(0,0,0,0.06);
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .card-header {
            background: #f9fafb;
            border-bottom: 1px solid #e8ecf0;
            border-radius: 12px 12px 0 0 !important;
            font-weight: 600;
            color: #1a1d23;
        }

        /* TABLE */
        .table { color: #1a1d23; }
        .table thead { background: #f9fafb; color: #6b7280; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1px; }
        .table tbody tr { border-color: #f3f4f6; }
        .table tbody tr:hover { background: #f9fafb; }

        /* FORMS */
        .form-control, .form-select {
            background: #f9fafb;
            border: 1px solid #e8ecf0;
            color: #1a1d23;
            border-radius: 8px;
        }
        .form-control:focus, .form-select:focus {
            background: white;
            border-color: #1a56db;
            color: #1a1d23;
            box-shadow: 0 0 0 3px rgba(26,86,219,0.1);
        }
        label { color: #374151; font-weight: 500; font-size: 0.875rem; }

        /* BUTTONS */
        .btn-primary { background: #1a56db; border-color: #1a56db; border-radius: 8px; font-weight: 600; }
        .btn-primary:hover { background: #1447c0; border-color: #1447c0; }
        .btn-success { background: #0e9f6e; border-color: #0e9f6e; border-radius: 8px; font-weight: 600; }
        .btn-warning { background: #f59e0b; border-color: #f59e0b; color: white; border-radius: 8px; font-weight: 600; }
        .btn-warning:hover { color: white; }
        .btn-danger { background: #ef4444; border-color: #ef4444; border-radius: 8px; font-weight: 600; }
        .btn-secondary { background: #f3f4f6; border-color: #e8ecf0; color: #374151; border-radius: 8px; font-weight: 600; }
        .btn-secondary:hover { background: #e5e7eb; color: #1a1d23; }

        /* ALERTS */
        .alert-success { background: #ecfdf5; border-color: #a7f3d0; color: #065f46; border-radius: 8px; }
        .alert-danger { background: #fef2f2; border-color: #fecaca; color: #991b1b; border-radius: 8px; }

        /* BADGES */
        .badge { border-radius: 6px; font-weight: 600; }

        /* TEXT */
        .text-muted { color: #9ca3af !important; }
        h2, h5, h6 { color: #1a1d23; }

        /* SCROLLBAR */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f3f4f6; }
        ::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 3px; }
    </style>
</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <div class="sidebar-brand">
        <div class="sidebar-brand-icon">🏨</div>
        <div>
            <div class="sidebar-brand-text">Grand Hôtel</div>
            <div class="sidebar-brand-sub">Portail de Gestion</div>
        </div>
    </div>

    <div class="sidebar-section">Menu</div>

    <a href="/dashboard" class="sidebar-link {{ request()->is('dashboard') ? 'active' : '' }}">
        <span class="icon">🏠</span> Dashboard
    </a>
    <a href="/chambres" class="sidebar-link {{ request()->is('chambres*') ? 'active' : '' }}">
        <span class="icon">🛏️</span> Chambres
    </a>
    <a href="/reservations" class="sidebar-link {{ request()->is('reservations*') ? 'active' : '' }}">
        <span class="icon">📋</span> Réservations
    </a>
    <a href="/clients" class="sidebar-link {{ request()->is('clients*') ? 'active' : '' }}">
        <span class="icon">👤</span> Clients
    </a>
    <a href="/factures" class="sidebar-link {{ request()->is('factures*') ? 'active' : '' }}">
        <span class="icon">🧾</span> Factures
    </a>

    <div class="sidebar-section">Support</div>
    <a href="/parametres" class="sidebar-link {{ request()->is('parametres*') ? 'active' : '' }}">
    <span class="icon">⚙️</span> Paramètres
    </a>
    <a href="#" class="sidebar-link">
        <span class="icon">❓</span> Aide
    </a>

    <div class="sidebar-footer">
        <div class="sidebar-user">
            <div class="sidebar-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</div>
            <div>
                <div class="sidebar-user-name">{{ auth()->user()->name }}</div>
                <div class="sidebar-user-role">Administrateur</div>
            </div>
            <form method="POST" action="/logout" class="ms-auto">
                @csrf
                <button class="btn btn-sm" style="background:none; border:none; color:#ef4444; font-size:1.1rem;" title="Déconnexion">🚪</button>
            </form>
        </div>
    </div>
</div>

<!-- TOPBAR -->
<div class="topbar">
    <div class="topbar-search">
        <span class="topbar-search-icon">🔍</span>
        <input type="text" placeholder="Rechercher chambres, clients, réservations...">
    </div>
    <div class="topbar-actions">
        <button class="btn btn-sm" style="background:#f3f4f6; border:1px solid #e8ecf0; border-radius:8px; position:relative;">
            🔔
            <span class="position-absolute top-0 end-0 translate-middle badge rounded-pill bg-danger" style="font-size:0.6rem;">3</span>
        </button>
        <a href="/reservations/create" class="btn-new-booking">
            + Nouvelle Réservation
        </a>
    </div>
</div>

<!-- MAIN CONTENT -->
<div class="main-content">
    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>