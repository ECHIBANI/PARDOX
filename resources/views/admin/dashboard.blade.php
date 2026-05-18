@extends('layouts.admin')
@section('title','Tableau de bord')
@section('page-title','Tableau de bord')

@section('extra-css')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>


.top-vehicle-img {
  width: 100%;
  height: 150px;
  object-fit: cover;
  border-radius: 12px;
  margin-bottom: .75rem;
}
.star-rating { color: #fbbf24; font-size: 1rem; letter-spacing: .1em; }
.other-car-item {
  display: flex;
  align-items: center;
  gap: .8rem;
  padding: .6rem .75rem;
  border-radius: 10px;
  border: 1px solid var(--border-color);
  background: #fafbff;
  transition: background .15s;
}
.other-car-item:hover { background: var(--blue-light); }
.other-car-thumb { width: 50px; height: 50px; border-radius: 8px; object-fit: cover; flex-shrink: 0; }
.other-car-rank { font-size: .75rem; font-weight: 800; color: var(--blue-primary); }
.other-car-name { font-weight: 700; font-size: .85rem; color: var(--text-dark); line-height: 1.2; }
.other-car-cat { font-size: .72rem; color: var(--text-muted); }
.other-car-count { font-size: .78rem; font-weight: 700; color: var(--orange-accent); margin-left: auto; white-space: nowrap; }

.see-all-btn {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: .4rem;
  width: 100%;
  padding: .65rem;
  border: 1px solid var(--border-color);
  border-radius: 10px;
  background: #fff;
  color: var(--blue-primary);
  font-weight: 600;
  font-size: .85rem;
  text-decoration: none;
  transition: all .15s;
  margin-top: .75rem;
}
.see-all-btn:hover { background: var(--blue-primary); color: #fff; }
</style>
@endsection

@section('content')
{{-- ── STATS ROW ── --}}
<div class="row g-3 mb-4">

  @php
  $statCards = [
    ['icon'=>'bi-calendar3',       'label'=>'Total réservations',  'value'=>$stats['total'],    'color'=>'#3b5bff', 'bg'=>'#eef1ff', 'spark'=>'blue'],
    ['icon'=>'bi-clock',           'label'=>'En attente',          'value'=>$stats['pending'],  'color'=>'#f97316', 'bg'=>'#fff7ed', 'spark'=>'orange'],
    ['icon'=>'bi-check-circle',    'label'=>'Confirmées',          'value'=>$stats['confirmed'],'color'=>'#22c55e', 'bg'=>'#f0fdf4', 'spark'=>'green'],
    ['icon'=>'bi-currency-exchange','label'=>'Revenu confirmé',    'value'=>number_format($stats['revenue'],0,',',' ').' DH','color'=>'#a855f7','bg'=>'#faf5ff','spark'=>'purple'],
    ['icon'=>'bi-car-front',       'label'=>'Véhicules',           'value'=>$stats['vehicles'], 'color'=>'#3b5bff', 'bg'=>'#eef1ff', 'spark'=>'blue'],
    ['icon'=>'bi-people',          'label'=>'Utilisateurs',        'value'=>$stats['users'],    'color'=>'#a855f7', 'bg'=>'#faf5ff', 'spark'=>'purple'],
  ];
  $sparkPaths = [
    'blue'  => 'M0,32 C20,28 30,20 50,18 C70,16 80,24 100,20 C120,16 130,8 150,10 C170,12 180,22 200,18',
    'orange'=> 'M0,28 C20,32 35,20 55,22 C75,24 85,14 105,16 C125,18 140,28 160,24 C180,20 190,10 200,12',
    'green' => 'M0,22 C20,26 35,16 55,14 C75,12 90,20 110,16 C130,12 145,8  165,12 C185,16 195,22 200,18',
    'purple'=> 'M0,26 C20,22 30,30 50,26 C70,22 85,12 105,14 C125,16 140,24 160,18 C180,12 195,8  200,10',
  ];
  $sparkColors = ['blue'=>'#3b5bff','orange'=>'#f97316','green'=>'#22c55e','purple'=>'#a855f7'];
  @endphp

  @foreach($statCards as $s)
  <div class="col-6 col-md-4 col-xl-2">
    <div class="stat-card h-100">
      <div class="stat-card-top">
        <div>
          <div class="stat-label">{{ $s['label'] }}</div>
          <div class="stat-value" style="white-space:nowrap;">{{ $s['value'] }}</div>
        </div>
        <div class="stat-icon-wrap" style="background:{{ $s['bg'] }};color:{{ $s['color'] }};">
          <i class="bi {{ $s['icon'] }}"></i>
        </div>
      </div>
      <div class="sparkline-wrap">
        <svg viewBox="0 0 200 42" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
          <defs>
            <linearGradient id="grad-{{ $loop->index }}" x1="0" y1="0" x2="0" y2="1">
              <stop offset="0%" stop-color="{{ $sparkColors[$s['spark']] }}" stop-opacity="0.18"/>
              <stop offset="100%" stop-color="{{ $sparkColors[$s['spark']] }}" stop-opacity="0"/>
            </linearGradient>
          </defs>
          <path d="{{ $sparkPaths[$s['spark']] }} L200,42 L0,42 Z" fill="url(#grad-{{ $loop->index }})"/>
          <path d="{{ $sparkPaths[$s['spark']] }}" fill="none" stroke="{{ $sparkColors[$s['spark']] }}" stroke-width="2" stroke-linecap="round"/>
        </svg>
      </div>
    </div>
  </div>
  @endforeach
</div>

{{-- ── CHART + PREFERRED CAR ── --}}
<div class="row g-4 mb-4">

  {{-- Chart --}}
  <div class="col-lg-8">
    <div class="table-card p-4 h-100">
      <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <h3 class="table-card-title m-0 d-flex align-items-center gap-2">
          <span style="width:34px;height:34px;background:#eef1ff;border-radius:9px;display:inline-flex;align-items:center;justify-content:center;">
            <i class="bi bi-bar-chart-fill" style="color:var(--blue-primary);"></i>
          </span>
          Statistiques des ventes
        </h3>
        <div class="d-flex gap-2" id="chartFilters">
          <button class="chart-filter-btn" onclick="loadStats('today', this)">Aujourd'hui</button>
          <button class="chart-filter-btn" onclick="loadStats('week', this)">Semaine</button>
          <button class="chart-filter-btn active" onclick="loadStats('month', this)">Mois</button>
        </div>
      </div>
      <div style="height:300px;position:relative;">
        <canvas id="statsChart"></canvas>
      </div>
    </div>
  </div>

  {{-- Preferred Vehicle --}}
  <div class="col-lg-4">
    <div class="table-card p-4 h-100 d-flex flex-column">
      <h3 class="table-card-title mb-4 d-flex align-items-center gap-2">
        <i class="bi bi-trophy-fill" style="color:#fbbf24;font-size:1.15rem;"></i>
        Véhicule préféré
      </h3>

      <div class="text-center py-4" id="topCarLoader">
        <div class="spinner-border" style="color:var(--blue-primary);" role="status"></div>
      </div>

      <div id="topCarsContent" class="d-none d-flex flex-column flex-grow-1">
        {{-- Top car hero --}}
        <div id="mainTopCar" class="mb-3 text-center"></div>

        <p style="font-size:.75rem;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:var(--text-muted);margin-bottom:.5rem;">
          Autres véhicules populaires
        </p>

        {{-- List --}}
        <div id="otherTopCars" class="d-flex flex-column gap-2 flex-grow-1"></div>

        <a href="{{ route('admin.vehicles') }}" class="see-all-btn">
          Voir tous les véhicules <i class="bi bi-chevron-right"></i>
        </a>
      </div>
    </div>
  </div>
</div>

{{-- ── MAP TRACKING ── --}}
<div class="row mb-4">
  <div class="col-12">
    <div class="table-card p-4">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="table-card-title m-0 d-flex align-items-center gap-2">
          <span style="width:34px;height:34px;background:#fee2e2;border-radius:9px;display:inline-flex;align-items:center;justify-content:center;">
            <i class="bi bi-geo-alt-fill" style="color:#ef4444;"></i>
          </span>
          Suivi des Véhicules en Circulation
        </h3>
        <span class="badge" style="background:#fef2f2;color:#ef4444;border:1px solid #fecaca;padding:.4rem .9rem;font-size:.75rem;border-radius:50px;font-weight:600;">
          <i class="bi bi-circle-fill me-1" style="font-size:.5rem;animation:pulse 2s infinite;"></i> En direct
        </span>
      </div>
      <div id="trackingMap" style="height:420px;border-radius:var(--radius-sm);border:1px solid var(--border-color);z-index:1;"></div>
    </div>
  </div>
</div>

{{-- ── PENDING RESERVATIONS ── --}}
@if($pending->count())
<div class="table-card">
  <div class="table-card-header">
    <span class="table-card-title d-flex align-items-center gap-2">
      <span style="width:30px;height:30px;background:#fff7ed;border-radius:8px;display:inline-flex;align-items:center;justify-content:center;">
        <i class="bi bi-clock" style="color:var(--orange-accent);font-size:.9rem;"></i>
      </span>
      Réservations en attente ({{ $pending->count() }})
    </span>
    <a href="{{ route('admin.reservations', ['status'=>'pending']) }}" class="btn-pardo-outline btn btn-sm">Voir toutes</a>
  </div>
  <table class="table table-pardo mb-0">
    <thead>
      <tr>
        <th>N° Réservation</th>
        <th>Client</th>
        <th>Véhicule</th>
        <th>Dates</th>
        <th>Total</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      @foreach($pending as $res)
      <tr>
        <td><span class="res-id">{{ $res->reservation_number }}</span></td>
        <td>
          <div class="d-flex align-items-center gap-2">
            <span class="cl-avatar">{{ strtoupper(substr($res->user->name,0,1)) }}</span>
            <div>
              <div class="fw-semibold" style="color:var(--text-dark);">{{ $res->user->name }}</div>
              <div class="text-muted" style="font-size:.75rem;">{{ $res->user->phone }}</div>
            </div>
          </div>
        </td>
        <td>{{ $res->vehicle->name }}</td>
        <td style="font-size:.8rem;">
          {{ $res->start_date->format('d/m/Y') }} → {{ $res->end_date->format('d/m/Y') }}<br>
          <span class="text-muted">{{ $res->days }} jour(s)</span>
        </td>
        <td><strong style="color:var(--blue-primary);">{{ number_format($res->total_price,0,',',' ') }} DH</strong></td>
        <td>
          <div class="d-flex gap-1 flex-wrap">
            <form action="{{ route('admin.reservations.status', $res) }}" method="POST" class="d-inline">
              @csrf @method('PATCH')
              <input type="hidden" name="status" value="confirmed">
              <button type="submit" class="btn btn-sm btn-success" style="border-radius:7px;font-size:.78rem;">
                <i class="bi bi-check-lg"></i> Confirmer
              </button>
            </form>
            <form action="{{ route('admin.reservations.status', $res) }}" method="POST" class="d-inline">
              @csrf @method('PATCH')
              <input type="hidden" name="status" value="rejected">
              <button type="submit" class="btn btn-sm btn-danger" style="border-radius:7px;font-size:.78rem;">
                <i class="bi bi-x-lg"></i> Refuser
              </button>
            </form>
            <a href="{{ route('admin.voucher', $res) }}" class="btn btn-sm btn-pardo-outline" style="font-size:.78rem;">
              <i class="bi bi-file-earmark-text"></i>
            </a>
          </div>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@else
<div class="text-center py-5" style="background:#fff;border-radius:var(--radius-md);border:1px solid var(--border-color);">
  <div style="width:64px;height:64px;background:#f0fdf4;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;margin-bottom:1rem;">
    <i class="bi bi-check-circle-fill" style="font-size:1.75rem;color:#22c55e;"></i>
  </div>
  <p class="text-muted mb-0">Aucune réservation en attente. Tout est à jour !</p>
</div>
@endif
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
// ── 1. CHART ──
let statsChart = null;

function loadStats(filter, btn) {
  if (btn) {
    document.querySelectorAll('#chartFilters button').forEach(b => {
      b.classList.remove('active');
    });
    btn.classList.add('active');
  }

  axios.get(`/api/stats?filter=${filter}`).then(res => {
    const data = res.data.chart;
    if (statsChart) statsChart.destroy();

    const ctx = document.getElementById('statsChart').getContext('2d');

    // Blue gradient fill
    const gradBlue = ctx.createLinearGradient(0, 0, 0, 300);
    gradBlue.addColorStop(0, 'rgba(59,91,255,0.18)');
    gradBlue.addColorStop(1, 'rgba(59,91,255,0)');

    statsChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: Object.keys(data.labels).length ? data.labels : ['Aucune donnée'],
        datasets: [
          {
            label: 'Revenus (DH)',
            data: Object.keys(data.revenues).length ? data.revenues : [0],
            borderColor: '#3b5bff',
            backgroundColor: gradBlue,
            borderWidth: 2.5,
            fill: true,
            tension: 0.45,
            pointRadius: 3,
            pointBackgroundColor: '#3b5bff',
            pointBorderColor: '#fff',
            pointBorderWidth: 2,
            yAxisID: 'y'
          },
          {
            label: 'Réservations',
            data: Object.keys(data.tickets).length ? data.tickets : [0],
            borderColor: '#f97316',
            backgroundColor: 'transparent',
            borderWidth: 2,
            borderDash: [5, 5],
            fill: false,
            tension: 0.4,
            pointRadius: 3,
            pointBackgroundColor: '#f97316',
            pointBorderColor: '#fff',
            pointBorderWidth: 2,
            yAxisID: 'y1'
          }
        ]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            position: 'top',
            align: 'end',
            labels: {
              usePointStyle: true,
              pointStyle: 'line',
              font: { family: 'Inter', size: 12 },
              color: '#64748b',
              boxWidth: 30,
              padding: 16
            }
          },
          tooltip: {
            backgroundColor: '#fff',
            titleColor: '#0f172a',
            bodyColor: '#64748b',
            borderColor: '#e8ecf0',
            borderWidth: 1,
            padding: 12,
            titleFont: { family: 'Inter', weight: '700' },
            bodyFont: { family: 'Inter' }
          }
        },
        scales: {
          x: {
            grid: { display: false },
            ticks: { font: { family: 'Inter', size: 11 }, color: '#94a3b8' }
          },
          y: {
            type: 'linear', position: 'left', beginAtZero: true,
            grid: { color: '#f1f5f9', drawBorder: false },
            ticks: { font: { family: 'Inter', size: 11 }, color: '#94a3b8' }
          },
          y1: {
            type: 'linear', position: 'right', beginAtZero: true,
            grid: { drawOnChartArea: false },
            ticks: { font: { family: 'Inter', size: 11 }, color: '#94a3b8' }
          }
        }
      }
    });
  });
}

// ── 2. TOP CARS ──
function loadTopCars() {
  axios.get('/api/cars').then(res => {
    document.getElementById('topCarLoader').classList.add('d-none');
    const content = document.getElementById('topCarsContent');
    content.classList.remove('d-none');

    const cars = res.data;
    if (cars.length === 0) {
      content.innerHTML = '<p class="text-muted text-center py-3">Aucun véhicule réservé.</p>';
      return;
    }

    const top = cars[0];
    const imgSrc = top.image.startsWith('http') ? top.image : '/storage/' + top.image;

    document.getElementById('mainTopCar').innerHTML = `
      <img src="${imgSrc}" alt="${top.name}" class="top-vehicle-img">
      <div style="font-weight:800;font-size:1.15rem;color:var(--text-dark);">${top.name}</div>
      <div style="font-size:.78rem;color:var(--text-muted);margin-bottom:.35rem;text-transform:uppercase;letter-spacing:.05em;">${top.category}</div>
      <div class="star-rating">★★★★★ <span style="font-size:.78rem;color:var(--text-muted);font-weight:400;">(${top.reservations_count} réservations)</span></div>
    `;

    let othersHTML = '';
    for (let i = 1; i < cars.length; i++) {
      const c = cars[i];
      const cImg = c.image.startsWith('http') ? c.image : '/storage/' + c.image;
      othersHTML += `
        <div class="other-car-item">
          <img src="${cImg}" alt="${c.name}" class="other-car-thumb">
          <div style="flex:1;min-width:0;">
            <div class="other-car-rank">#${i + 1}</div>
            <div class="other-car-name">${c.name}</div>
            <div class="other-car-cat">${c.category}</div>
          </div>
          <div class="other-car-count">${c.reservations_count} fois</div>
        </div>`;
    }
    document.getElementById('otherTopCars').innerHTML = othersHTML;
  });
}

// ── 3. MAP ──
function initMap() {
  const map = L.map('trackingMap').setView([31.7917, -7.0926], 6);
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap contributors',
    maxZoom: 18,
  }).addTo(map);

  axios.get('/api/tracking').then(res => {
    const markers = res.data;
    markers.forEach(car => {
      const color = car.status === 'Busy' ? '#ef4444' : '#22c55e';
      const iconHtml = `<div style="background-color:${color};width:14px;height:14px;border-radius:50%;border:3px solid white;box-shadow:0 0 5px rgba(0,0,0,.4);"></div>`;
      const customIcon = L.divIcon({ html: iconHtml, className: '', iconSize: [14, 14], iconAnchor: [7, 7] });
      const marker = L.marker([car.latitude, car.longitude], { icon: customIcon }).addTo(map);
      const badgeClass = car.status === 'Busy' ? 'bg-danger' : 'bg-success';
      const statusLabel = car.status === 'Busy' ? 'En location' : 'Disponible';
      marker.bindPopup(`
        <div style="text-align:center;min-width:120px;font-family:Inter,sans-serif;">
          <strong style="display:block;margin-bottom:4px;font-size:1rem;">${car.car_name}</strong>
          <div style="font-size:.75rem;color:#64748b;margin-bottom:5px;">${car.car_model}</div>
          <span class="badge ${badgeClass}" style="font-size:.7rem;">${statusLabel}</span>
        </div>`);
    });
  });
}

document.addEventListener('DOMContentLoaded', () => {
  loadStats('month', null);
  loadTopCars();
  initMap();
});
</script>
@endsection
