<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title','Admin') — PARDOX</title>
<link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Barlow+Condensed:wght@400;600;700;800&display=swap" rel="stylesheet">
<style>
:root {
  --blue-primary: #3b5bff;
  --blue-light: #eef1ff;
  --blue-dark: #2a45e8;
  --orange-accent: #f97316;
  --green-accent: #22c55e;
  --purple-accent: #a855f7;
  --yellow-accent: #fbbf24;
  --red-accent: #ef4444;
  --sidebar-bg: #fff;
  --content-bg: #f4f6fb;
  --card-bg: #fff;
  --text-dark: #0f172a;
  --text-muted: #64748b;
  --text-light: #94a3b8;
  --border-color: #c8cfd8;
  --radius-sm: 10px;
  --radius-md: 14px;
  --radius-lg: 20px;
  --shadow-sm: 0 1px 4px rgba(0,0,0,.04);
  --shadow-md: 0 4px 20px rgba(0,0,0,.07);
  --shadow-lg: 0 8px 32px rgba(0,0,0,.10);
}

* { box-sizing: border-box; }
body { font-family: 'Inter', sans-serif; color: var(--text-dark); background: var(--content-bg); margin: 0; }

/* ── LAYOUT ── */
.admin-layout { display: flex; min-height: 100vh; }

/* ── SIDEBAR ── */
.admin-sidebar {
  width: 220px;
  min-height: 100vh;
  background: var(--sidebar-bg);
  border-right: 1px solid var(--border-color);
  display: flex;
  flex-direction: column;
  flex-shrink: 0;
  position: sticky;
  top: 0;
  height: 100vh;
  overflow-y: auto;
  z-index: 100;
}

.sidebar-brand {
  display: flex;
  align-items: center;
  padding: 1.25rem 1.2rem;
  border-bottom: 1px solid var(--border-color);
  gap: .5rem;
}
.sidebar-brand img { height: 36px; object-fit: contain; }

.sidebar-nav { padding: .75rem 0; flex: 1; }
.sidebar-nav ul { list-style: none; padding: 0; margin: 0; }
.sidebar-nav li { padding: .15rem .75rem; }

.sidebar-link {
  display: flex;
  align-items: center;
  gap: .7rem;
  padding: .65rem .85rem;
  border-radius: 10px;
  color: var(--text-muted);
  font-size: .875rem;
  font-weight: 500;
  transition: all .18s ease;
  text-decoration: none;
  border: none;
  background: transparent;
  width: 100%;
  text-align: left;
  cursor: pointer;
}
.sidebar-link i { font-size: 1.05rem; width: 20px; text-align: center; }
.sidebar-link:hover { background: var(--blue-light); color: var(--blue-primary); }
.sidebar-link:hover i { color: var(--blue-primary); }
.sidebar-link.active { background: var(--blue-primary); color: #fff; font-weight: 600; box-shadow: 0 4px 12px rgba(59,91,255,.3); }
.sidebar-link.active i { color: #fff; }

.sidebar-badge { background: var(--orange-accent); color: #fff; font-size: .65rem; font-weight: 700; padding: .1rem .45rem; border-radius: 20px; margin-left: auto; }

.sidebar-footer {
  padding: 1rem 1.2rem 1.25rem;
  border-top: 1px solid var(--border-color);
}
.help-box {
  background: var(--blue-light);
  border-radius: var(--radius-md);
  padding: .9rem;
  font-size: .78rem;
}
.help-box .help-icon { width: 30px; height: 30px; background: var(--blue-primary); border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; color: #fff; margin-bottom: .5rem; }
.help-box p { color: var(--text-muted); margin: .25rem 0 .5rem; font-size: .75rem; line-height: 1.4; }
.help-box a { color: var(--blue-primary); font-weight: 600; text-decoration: none; font-size: .78rem; }
.help-box a:hover { text-decoration: underline; }

/* ── MAIN ── */
.admin-main { flex: 1; min-width: 0; display: flex; flex-direction: column; }

.admin-topbar {
  height: 68px;
  background: #fff;
  border-bottom: 1px solid var(--border-color);
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0 1.75rem;
  box-shadow: var(--shadow-sm);
  position: sticky;
  top: 0;
  z-index: 50;
}
.topbar-left {}
.topbar-title { font-family: 'Inter', sans-serif; font-weight: 800; font-size: 1.25rem; color: var(--text-dark); display: block; line-height: 1.2; }
.topbar-subtitle { font-size: .75rem; color: var(--text-muted); font-weight: 400; margin-top: .1rem; display: block; }

.topbar-right { display: flex; align-items: center; gap: 1rem; }

.admin-avatar {
  width: 36px; height: 36px;
  background: var(--blue-primary);
  color: #fff;
  border-radius: 50%;
  display: inline-flex; align-items: center; justify-content: center;
  font-weight: 700; font-size: .85rem;
  flex-shrink: 0;
}
.admin-name { font-size: .875rem; font-weight: 700; color: var(--text-dark); line-height: 1.1; }
.admin-role { font-size: .65rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: .08em; font-weight: 600; }
.topbar-chevron { color: var(--text-muted); font-size: .85rem; cursor: pointer; }

.admin-content { padding: 1.5rem 1.75rem; flex: 1; }

/* ── STAT CARDS ── */
.stat-card {
  background: #fff;
  border-radius: var(--radius-md);
  border: 1px solid var(--border-color);
  box-shadow: var(--shadow-sm);
  padding: 1.2rem 1.3rem 0.8rem;
  transition: transform .2s, box-shadow .2s;
  overflow: hidden;
}
.stat-card:hover { transform: translateY(-3px); box-shadow: var(--shadow-md); }

.stat-card-top { display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: .4rem; }
.stat-icon-wrap {
  width: 42px; height: 42px;
  border-radius: 10px;
  display: flex; align-items: center; justify-content: center;
  font-size: 1.2rem;
  flex-shrink: 0;
}
.stat-label { font-size: .68rem; font-weight: 700; text-transform: uppercase; letter-spacing: .07em; color: var(--text-muted); margin-bottom: .25rem; }
.stat-value { font-family: 'Barlow Condensed', sans-serif; font-weight: 800; font-size: 2rem; color: var(--text-dark); line-height: 1; }

.sparkline-wrap { margin: 0 -1.3rem; margin-top: .5rem; height: 42px; overflow: hidden; }
.sparkline-wrap svg { width: 100%; height: 42px; display: block; }

/* ── TABLE CARD ── */
.table-card { background: #fff; border-radius: var(--radius-md); border: 1px solid var(--border-color); box-shadow: var(--shadow-sm); overflow: hidden; }
.table-card-header { display: flex; align-items: center; justify-content: space-between; padding: 1.1rem 1.5rem; border-bottom: 1px solid var(--border-color); flex-wrap: wrap; gap: .75rem; }
.table-card-title { font-family: 'Inter', sans-serif; font-weight: 700; font-size: 1rem; color: var(--text-dark); }

.table-pardo thead th { font-size: .68rem; font-weight: 700; text-transform: uppercase; letter-spacing: .07em; color: var(--text-muted); background: #f8fafc; border-bottom: 1px solid var(--border-color); padding: .75rem 1rem; white-space: nowrap; }
.table-pardo tbody td { padding: .85rem 1rem; vertical-align: middle; font-size: .875rem; }
.table-pardo tbody tr { border-bottom: 1px solid var(--border-color); transition: background .15s; }
.table-pardo tbody tr:last-child { border-bottom: none; }
.table-pardo tbody tr:hover { background: #f8fafc; }

.res-id { font-family: 'Barlow Condensed', sans-serif; font-weight: 700; color: var(--text-dark); background: #f1f5f9; padding: .2rem .55rem; border-radius: 6px; font-size: .85rem; }
.cl-avatar { width: 30px; height: 30px; background: var(--blue-primary); color: #fff; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-weight: 700; font-size: .75rem; flex-shrink: 0; }

.status-pill { display: inline-flex; align-items: center; justify-content: center; gap: .35rem; font-size: .75rem; font-weight: 600; padding: .3rem .75rem; border-radius: 50px; min-width: 110px; text-align: center; white-space: nowrap; }
.badge-pending { background: #fef3c7; color: #d97706; border: 1px solid #fde68a; }
.badge-confirmed { background: #dcfce7; color: #16a34a; border: 1px solid #bbf7d0; }
.badge-rejected { background: #fee2e2; color: #ef4444; border: 1px solid #fecaca; }
.badge-completed { background: #f0f4ff; color: var(--blue-primary); border: 1px solid #c7d2fe; }

/* ── BUTTONS ── */
.btn-pardo-primary { background: var(--blue-primary); color: #fff; border: none; border-radius: 8px; font-weight: 600; padding: .5rem 1.2rem; transition: all .2s; text-decoration: none; display: inline-flex; align-items: center; font-size: .875rem; }
.btn-pardo-primary:hover { background: var(--blue-dark); color: #fff; transform: translateY(-1px); }
.btn-pardo-orange { background: var(--orange-accent); color: #fff; border: none; border-radius: 8px; font-weight: 600; padding: .5rem 1.2rem; transition: all .2s; text-decoration: none; display: inline-flex; align-items: center; }
.btn-pardo-orange:hover { background: #ea6a0a; color: #fff; }
.btn-pardo-outline { border: 1.5px solid var(--border-color); background: transparent; color: var(--text-dark); border-radius: 8px; font-weight: 600; padding: .45rem 1rem; transition: all .2s; text-decoration: none; display: inline-flex; align-items: center; font-size: .875rem; }
.btn-pardo-outline:hover { background: var(--blue-primary); color: #fff; border-color: var(--blue-primary); }

/* ── VEHICLE CARD ── */
.vehicle-card-admin { background: #fff; border-radius: var(--radius-lg); border: 1px solid var(--border-color); overflow: hidden; box-shadow: var(--shadow-sm); }
.vehicle-img-wrap { height: 180px; overflow: hidden; position: relative; background: #f1f5f9; }
.vehicle-img { width: 100%; height: 100%; object-fit: cover; transition: transform .4s; }
.vehicle-card-admin:hover .vehicle-img { transform: scale(1.04); }
.cat-badge { position: absolute; bottom: .75rem; left: .75rem; background: #000; color: #fff; font-size: .68rem; font-weight: 700; padding: .2rem .6rem; border-radius: 50px; text-transform: uppercase; letter-spacing: .06em; }

/* ── CAR LIST ── */
.car-list-item { display: flex; align-items: center; gap: .85rem; padding: .65rem .75rem; border-radius: 10px; border: 1px solid var(--border-color); background: #fafbff; transition: box-shadow .15s, background .15s; }
.car-list-item:hover { background: var(--blue-light); box-shadow: var(--shadow-sm); }
.car-list-img { width: 52px; height: 52px; border-radius: 8px; object-fit: cover; }
.car-rank { font-size: .68rem; font-weight: 800; color: var(--blue-primary); background: var(--blue-light); border-radius: 6px; padding: .1rem .4rem; margin-right: .2rem; }

/* ── CHART FILTER BUTTONS ── */
.chart-filter-btn { border: 1px solid var(--border-color); background: #fff; color: var(--text-muted); padding: .35rem .85rem; border-radius: 8px; font-size: .8rem; font-weight: 500; cursor: pointer; transition: all .15s; }
.chart-filter-btn:hover { background: var(--blue-light); color: var(--blue-primary); border-color: #c7d2fe; }
.chart-filter-btn.active { background: var(--blue-primary); color: #fff; border-color: var(--blue-primary); }

@keyframes pulse { 0% { opacity: 1; transform: scale(1); } 50% { opacity: 0.5; transform: scale(1.5); } 100% { opacity: 1; transform: scale(1); } }
.section-title-admin { font-family: 'Inter', sans-serif; font-weight: 800; font-size: 1.5rem; color: var(--text-dark); }

/* ── PAGE ANIMATIONS ── */
@keyframes fadeInUp {
  from { opacity: 0; transform: translateY(22px); }
  to   { opacity: 1; transform: translateY(0); }
}
@keyframes fadeInLeft {
  from { opacity: 0; transform: translateX(-18px); }
  to   { opacity: 1; transform: translateX(0); }
}
@keyframes slideDown {
  from { opacity: 0; transform: translateY(-12px); }
  to   { opacity: 1; transform: translateY(0); }
}
@keyframes scaleIn {
  from { opacity: 0; transform: scale(.94); }
  to   { opacity: 1; transform: scale(1); }
}
@keyframes loaderSpin {
  to { transform: rotate(360deg); }
}
@keyframes loaderFade {
  to { opacity: 0; visibility: hidden; pointer-events: none; }
}



/* Sidebar animation */
body.page-animating .admin-sidebar {
  animation: fadeInLeft .45s cubic-bezier(.22,1,.36,1) both;
}
body.page-animating .sidebar-nav li {
  animation: fadeInLeft .4s cubic-bezier(.22,1,.36,1) both;
}
body.page-animating .sidebar-nav li:nth-child(1) { animation-delay: .08s; }
body.page-animating .sidebar-nav li:nth-child(2) { animation-delay: .13s; }
body.page-animating .sidebar-nav li:nth-child(3) { animation-delay: .18s; }
body.page-animating .sidebar-nav li:nth-child(4) { animation-delay: .23s; }
body.page-animating .sidebar-nav li:nth-child(5) { animation-delay: .28s; }

/* Topbar animation */
body.page-animating .admin-topbar {
  animation: slideDown .4s cubic-bezier(.22,1,.36,1) both;
  animation-delay: .1s;
}

/* Content animation */
body.page-animating .admin-content {
  animation: fadeInUp .5s cubic-bezier(.22,1,.36,1) both;
  animation-delay: .18s;
}

/* Table rows stagger */
body.page-animating .table-pardo tbody tr {
  animation: fadeInUp .35s ease both;
}
body.page-animating .table-pardo tbody tr:nth-child(1)  { animation-delay: .20s; }
body.page-animating .table-pardo tbody tr:nth-child(2)  { animation-delay: .25s; }
body.page-animating .table-pardo tbody tr:nth-child(3)  { animation-delay: .30s; }
body.page-animating .table-pardo tbody tr:nth-child(4)  { animation-delay: .35s; }
body.page-animating .table-pardo tbody tr:nth-child(5)  { animation-delay: .40s; }
body.page-animating .table-pardo tbody tr:nth-child(6)  { animation-delay: .45s; }
body.page-animating .table-pardo tbody tr:nth-child(7)  { animation-delay: .48s; }
body.page-animating .table-pardo tbody tr:nth-child(8)  { animation-delay: .50s; }
body.page-animating .table-pardo tbody tr:nth-child(n+9){ animation-delay: .52s; }

/* Stat cards stagger */
body.page-animating .stat-card { animation: scaleIn .4s cubic-bezier(.22,1,.36,1) both; }
body.page-animating .col-6:nth-child(1) .stat-card,
body.page-animating .col-md-4:nth-child(1) .stat-card { animation-delay: .15s; }
body.page-animating .col-6:nth-child(2) .stat-card,
body.page-animating .col-md-4:nth-child(2) .stat-card { animation-delay: .20s; }
body.page-animating .col-6:nth-child(3) .stat-card { animation-delay: .25s; }
body.page-animating .col-6:nth-child(4) .stat-card { animation-delay: .30s; }
body.page-animating .col-6:nth-child(5) .stat-card { animation-delay: .35s; }
body.page-animating .col-6:nth-child(6) .stat-card { animation-delay: .40s; }

/* Cards generic */
body.page-animating .table-card {
  animation: fadeInUp .45s cubic-bezier(.22,1,.36,1) both;
  animation-delay: .22s;
}

/* ── FORM INPUTS BORDERS (force visible) ── */
.form-control,
.form-select {
  border: 1.5px solid #b0b8c4 !important;
  border-radius: var(--radius-sm);
  transition: border-color .15s, box-shadow .15s;
}
.form-control:focus,
.form-select:focus {
  border-color: var(--blue-primary) !important;
  box-shadow: 0 0 0 3px rgba(59,91,255,.12) !important;
}
.input-group .form-control { border-right: none !important; }
.input-group .input-group-text {
  border: 1.5px solid #b0b8c4;
  border-left: none;
  background: #f8fafc;
  color: var(--text-muted);
  font-weight: 600;
}
</style>
@yield('extra-css')
</head>
<body class="page-animating">
<script>
  // Remove animation class after all animations complete (800ms)
  setTimeout(() => document.body.classList.remove('page-animating'), 800);
</script>


<div class="admin-layout">

  {{-- SIDEBAR --}}
  <aside class="admin-sidebar">
    <div class="sidebar-brand">
      <img src="{{ asset('images/logo.png') }}" alt="PARDOX">
    </div>
    <nav class="sidebar-nav">
      <ul>
        <li>
          <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> Tableau de bord
          </a>
        </li>
        <li>
          <a href="{{ route('admin.reservations') }}" class="sidebar-link {{ request()->routeIs('admin.reservations*') ? 'active' : '' }}">
            <i class="bi bi-calendar3"></i> Réservations
            @php $pendingCount = \App\Models\Reservation::where('status','pending')->count(); @endphp
            @if($pendingCount > 0)
            <span class="sidebar-badge">{{ $pendingCount }}</span>
            @endif
          </a>
        </li>
        <li>
          <a href="{{ route('admin.vehicles') }}" class="sidebar-link {{ request()->routeIs('admin.vehicles*') ? 'active' : '' }}">
            <i class="bi bi-car-front"></i> Véhicules
          </a>
        </li>
        <li>
          <a href="{{ route('admin.users') }}" class="sidebar-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
            <i class="bi bi-people"></i> Utilisateurs
          </a>
        </li>

        <li style="margin-top:1rem;">
          <form action="{{ parse_url(route('logout'), PHP_URL_PATH) }}" method="POST">
            @csrf
            <button type="submit" class="sidebar-link" style="color:#ef4444;">
              <i class="bi bi-box-arrow-right" style="color:#ef4444;"></i> Déconnexion
            </button>
          </form>
        </li>
      </ul>
    </nav>

    <div class="sidebar-footer">
      <div class="help-box">
        <div class="help-icon"><i class="bi bi-headset" style="font-size:.85rem;"></i></div>
        <strong style="font-size:.8rem;color:#0f172a;">Besoin d'aide ?</strong>
        <p>Notre support est là pour vous aider.</p>
        <a href="#">Nous contacter →</a>
      </div>
    </div>
  </aside>

  {{-- MAIN --}}
  <main class="admin-main">
    <div class="admin-topbar">
      <div class="topbar-left">
        <span class="topbar-title">@yield('page-title','Dashboard')</span>
        <span class="topbar-subtitle">Vue d'ensemble de votre activité</span>
      </div>
      <div class="topbar-right">
        @if(session('success'))
        <span class="badge text-bg-success py-2 px-3">✓ {{ session('success') }}</span>
        @endif
        <div class="d-flex align-items-center gap-2" style="cursor:pointer;">
          <div class="admin-avatar">{{ strtoupper(substr(auth()->user()->name,0,1)) }}</div>
          <div>
            <div class="admin-name">{{ auth()->user()->name }}</div>
            <div class="admin-role">Administrateur</div>
          </div>
          <i class="bi bi-chevron-down topbar-chevron ms-1"></i>
        </div>
      </div>
    </div>

    <div class="admin-content">
      @if($errors->any())
      <div class="alert alert-danger alert-dismissible fade show mb-4" style="border-radius:var(--radius-sm);">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        @foreach($errors->all() as $err)<div>{{ $err }}</div>@endforeach
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
      @endif

      @yield('content')
    </div>
  </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

@yield('scripts')
</body>
</html>
