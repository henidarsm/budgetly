<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') - Budgetly</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }
        :root { --sidebar-width: 260px; --primary: #1565C0; --primary-light: #42A5F5; }
        body { background: #F0F4FF; margin: 0; }
        .sidebar { position: fixed; top: 0; left: 0; height: 100vh; width: var(--sidebar-width); background: linear-gradient(180deg, #0A1628 0%, #0D2366 60%, #1A3A7A 100%); z-index: 1000; display: flex; flex-direction: column; transition: .3s; overflow-y: auto; }
        .sidebar-brand { padding: 24px 20px; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .sidebar-brand .brand { display: flex; align-items: center; gap: 12px; text-decoration: none; }
        .sidebar-brand .logo-icon { width: 44px; height: 44px; background: linear-gradient(135deg, #1565C0, #42A5F5); border-radius: 12px; display: flex; align-items: center; justify-content: center; }
        .sidebar-brand .logo-icon i { color: white; font-size: 20px; }
        .sidebar-brand .logo-text { color: white; font-size: 20px; font-weight: 800; }
        .sidebar-brand .logo-text span { color: #64B5F6; }
        .sidebar-brand .badge-admin { background: #FF6B35; color: white; font-size: 10px; padding: 2px 8px; border-radius: 20px; font-weight: 600; }
        .sidebar-nav { padding: 20px 0; flex: 1; }
        .nav-section-title { color: rgba(255,255,255,0.4); font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; padding: 8px 20px; margin-top: 12px; }
        .nav-item-custom { padding: 4px 12px; }
        .nav-link-custom { display: flex; align-items: center; gap: 12px; padding: 11px 14px; border-radius: 12px; color: rgba(255,255,255,0.7); text-decoration: none; transition: all .2s; font-size: 14px; font-weight: 500; }
        .nav-link-custom:hover, .nav-link-custom.active { background: rgba(255,255,255,0.12); color: white; }
        .nav-link-custom.active { background: linear-gradient(135deg, rgba(21,101,192,0.8), rgba(66,165,245,0.4)); }
        .nav-link-custom i { width: 20px; text-align: center; font-size: 15px; }
        .sidebar-footer { padding: 16px 20px; border-top: 1px solid rgba(255,255,255,0.1); }
        .user-info { display: flex; align-items: center; gap: 12px; }
        .user-avatar-img { width: 38px; height: 38px; border-radius: 10px; object-fit: cover; border: 2px solid rgba(255,255,255,0.2); flex-shrink: 0; }
        .user-details .name { color: white; font-size: 13px; font-weight: 600; }
        .user-details .role { color: rgba(255,255,255,0.5); font-size: 11px; }
        .main-content { margin-left: var(--sidebar-width); min-height: 100vh; }
        .topbar { background: white; padding: 0 28px; height: 68px; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 2px 10px rgba(0,0,0,0.06); position: sticky; top: 0; z-index: 100; }
        .topbar-title h5 { margin: 0; font-weight: 700; color: #1E293B; font-size: 17px; }
        .topbar-title p { margin: 0; font-size: 13px; color: #64748B; }
        .topbar-right { display: flex; align-items: center; gap: 16px; }
        .page-content { padding: 24px 28px; }
        .stat-card { background: white; border-radius: 16px; padding: 24px; box-shadow: 0 2px 12px rgba(0,0,0,0.06); border: 1px solid #E8F0FE; transition: all .3s; }
        .stat-card:hover { transform: translateY(-4px); box-shadow: 0 8px 24px rgba(21,101,192,0.15); }
        .stat-icon { width: 52px; height: 52px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 22px; }
        .stat-value { font-size: 26px; font-weight: 800; color: #1E293B; margin: 8px 0 4px; }
        .stat-label { font-size: 13px; color: #64748B; font-weight: 500; }
        .card-custom { background: white; border-radius: 16px; box-shadow: 0 2px 12px rgba(0,0,0,0.06); border: 1px solid #E8F0FE; }
        .card-header-custom { padding: 18px 22px; border-bottom: 1px solid #F1F5F9; display: flex; align-items: center; justify-content: space-between; }
        .card-header-custom h6 { margin: 0; font-weight: 700; color: #1E293B; font-size: 15px; }
        .table-custom th { background: #F8FAFF; color: #64748B; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: .5px; border: none; padding: 12px 16px; }
        .table-custom td { padding: 12px 16px; border-color: #F1F5F9; vertical-align: middle; font-size: 14px; }
        .table-custom tbody tr:hover { background: #F8FAFF; }
        .badge-status { padding: 5px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; }
        .badge-active { background: #DCFCE7; color: #16A34A; }
        .badge-inactive { background: #FEE2E2; color: #DC2626; }
        .badge-admin { background: #EDE9FE; color: #7C3AED; }
        .badge-user { background: #DBEAFE; color: #1D4ED8; }
        .badge-cat { padding: 5px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; }
        .btn-icon { width: 34px; height: 34px; border-radius: 8px; border: none; display: inline-flex; align-items: center; justify-content: center; transition: all .2s; font-size: 14px; }
        .btn-blue { background: #EFF6FF; color: #1565C0; }
        .btn-blue:hover { background: #1565C0; color: white; }
        .btn-red { background: #FEF2F2; color: #DC2626; }
        .btn-red:hover { background: #DC2626; color: white; }
        .btn-green { background: #F0FDF4; color: #16A34A; }
        .btn-green:hover { background: #16A34A; color: white; }
        .btn-orange { background: #FFF7ED; color: #EA580C; }
        .btn-orange:hover { background: #EA580C; color: white; }
        .btn-primary-custom { background: linear-gradient(135deg, #1565C0, #1976D2); border: none; border-radius: 10px; padding: 10px 20px; font-weight: 600; color: white; transition: all .3s; font-size: 14px; display: inline-flex; align-items: center; gap: 6px; text-decoration: none; }
        .btn-primary-custom:hover { background: linear-gradient(135deg, #0D47A1, #1565C0); transform: translateY(-1px); box-shadow: 0 4px 15px rgba(21,101,192,0.4); color: white; }
        .btn-outline-primary-custom { border: 2px solid #1565C0; color: #1565C0; border-radius: 10px; padding: 9px 20px; font-weight: 600; font-size: 14px; transition: all .3s; background: white; display: inline-flex; align-items: center; gap: 6px; text-decoration: none; }
        .btn-outline-primary-custom:hover { background: #1565C0; color: white; }
        .btn-danger-custom { background: linear-gradient(135deg, #DC2626, #EF4444); border: none; border-radius: 10px; padding: 10px 20px; font-weight: 600; color: white; transition: all .3s; font-size: 14px; display: inline-flex; align-items: center; gap: 6px; }
        .btn-danger-custom:hover { background: linear-gradient(135deg, #B91C1C, #DC2626); color: white; }
        .form-control, .form-select { border: 2px solid #E5E7EB; border-radius: 10px; padding: 10px 14px; font-size: 14px; transition: all .3s; }
        .form-control:focus, .form-select:focus { border-color: #1565C0; box-shadow: 0 0 0 3px rgba(21,101,192,0.1); }
        .alert-custom { border-radius: 12px; border: none; padding: 14px 18px; font-size: 14px; font-weight: 500; }
        .alert-success-custom { background: #F0FDF4; color: #166534; border-left: 4px solid #22C55E; }
        .alert-danger-custom { background: #FEF2F2; color: #991B1B; border-left: 4px solid #EF4444; }
        .hamburger { display: none; background: none; border: none; font-size: 22px; color: #1565C0; cursor: pointer; }
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .main-content { margin-left: 0; }
            .hamburger { display: block; }
        }
    </style>
    @stack('styles')
</head>
<body>

@php
$avatarPhotos = [
    '1570295999919-56ceb5ecca61',
    '1472099645785-5658abf4ff4e',
    '1507003211169-0a1dd7228f2d',
    '1438761681033-6461ffad8d80',
    '1494790108377-be9c29b29330',
    '1500648767791-00dcc994a43e',
    '1534528741775-53994a69daeb',
    '1508214751196-bcfd4ca60f91',
];
$myAvatarId = $avatarPhotos[auth()->user()->id % count($avatarPhotos)];
@endphp

<div class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <a class="brand" href="{{ route('admin.dashboard') }}">
            <div class="logo-icon"><i class="fas fa-chart-pie"></i></div>
            <div>
                <div class="logo-text">Budget<span>ly</span></div>
                <span class="badge-admin">ADMIN</span>
            </div>
        </a>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-section-title">Menu Utama</div>
        <div class="nav-item-custom">
            <a href="{{ route('admin.dashboard') }}" class="nav-link-custom {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-th-large"></i> Dashboard
            </a>
        </div>

        <div class="nav-section-title">Manajemen</div>
        <div class="nav-item-custom">
            <a href="{{ route('admin.users.index') }}" class="nav-link-custom {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <i class="fas fa-users"></i> Data Pengguna
            </a>
        </div>
        <div class="nav-item-custom">
            <a href="{{ route('admin.expenses.index') }}" class="nav-link-custom {{ request()->routeIs('admin.expenses.*') ? 'active' : '' }}">
                <i class="fas fa-receipt"></i> Semua Pengeluaran
            </a>
        </div>
        <div class="nav-item-custom">
            <a href="{{ route('admin.categories.index') }}" class="nav-link-custom {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                <i class="fas fa-tags"></i> Kategori Global
            </a>
        </div>
    </nav>

    <div class="sidebar-footer">
        <div class="user-info">
            <img
                src="https://images.unsplash.com/photo-{{ $myAvatarId }}?w=76&h=76&fit=crop&crop=face"
                alt="{{ auth()->user()->name }}"
                class="user-avatar-img"
            >
            <div class="user-details">
                <div class="name">{{ Str::limit(auth()->user()->name, 14) }}</div>
                <div class="role">Administrator</div>
            </div>
            <form method="POST" action="{{ route('logout') }}" class="ms-auto">
                @csrf
                <button type="submit" class="btn btn-sm" style="color:rgba(255,255,255,0.5); background:transparent; border:none;" title="Logout">
                    <i class="fas fa-sign-out-alt"></i>
                </button>
            </form>
        </div>
    </div>
</div>

<div class="main-content">
    <div class="topbar">
        <div class="d-flex align-items-center gap-3">
            <button class="hamburger" onclick="toggleSidebar()"><i class="fas fa-bars"></i></button>
            <div class="topbar-title">
                <h5>@yield('page-title', 'Dashboard')</h5>
                <p>@yield('page-subtitle', 'Selamat datang di panel admin Budgetly')</p>
            </div>
        </div>
        <div class="topbar-right">
            <div class="d-none d-md-flex align-items-center gap-2 px-3 py-2 rounded-3" style="background:#F0F4FF;">
                <img
                    src="https://images.unsplash.com/photo-{{ $myAvatarId }}?w=64&h=64&fit=crop&crop=face"
                    class="rounded-circle" width="32" height="32" alt="{{ auth()->user()->name }}"
                    style="object-fit:cover;"
                >
                <div>
                    <div style="font-size:13px;font-weight:600;color:#1E293B;">{{ Str::limit(auth()->user()->name, 18) }}</div>
                    <div style="font-size:11px;color:#64748B;">Administrator</div>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-sm" style="background:#FEF2F2;color:#DC2626;border-radius:10px;padding:8px 14px;font-weight:600;font-size:13px;border:none;">
                    <i class="fas fa-sign-out-alt me-1"></i> Keluar
                </button>
            </form>
        </div>
    </div>

    <div class="page-content">
        @if(session('success'))
            <div class="alert alert-custom alert-success-custom d-flex align-items-center gap-2 mb-4" id="flash-msg">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close ms-auto" onclick="this.parentElement.remove()"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-custom alert-danger-custom d-flex align-items-center gap-2 mb-4" id="flash-msg">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                <button type="button" class="btn-close ms-auto" onclick="this.parentElement.remove()"></button>
            </div>
        @endif

        @yield('content')
    </div>
</div>

<div id="overlay" onclick="toggleSidebar()" style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.5);z-index:999;"></div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
function toggleSidebar() {
    const s = document.getElementById('sidebar');
    const o = document.getElementById('overlay');
    s.classList.toggle('open');
    o.style.display = s.classList.contains('open') ? 'block' : 'none';
}
setTimeout(() => { const m = document.getElementById('flash-msg'); if(m) m.remove(); }, 5000);
</script>
@stack('scripts')
</body>
</html>
