@extends('layouts.admin')
@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard Admin')
@section('page-subtitle', 'Ringkasan aktivitas sistem Budgetly')

@section('content')
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
@endphp

<div class="row g-4 mb-4">
    <div class="col-md-3 col-sm-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label">Total Pengguna</div>
                    <div class="stat-value">{{ number_format($totalUsers) }}</div>
                    <span style="font-size:12px;color:#16A34A;font-weight:600;"><i class="fas fa-circle" style="font-size:8px;"></i> {{ $activeUsers }} aktif</span>
                </div>
                <div class="stat-icon" style="background:#EFF6FF;"><i class="fas fa-users" style="color:#1565C0;"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label">Total Pengeluaran</div>
                    <div class="stat-value" style="font-size:20px;">Rp {{ number_format($totalExpenses, 0, ',', '.') }}</div>
                    <span style="font-size:12px;color:#64748B;">Semua periode</span>
                </div>
                <div class="stat-icon" style="background:#F0FDF4;"><i class="fas fa-money-bill-wave" style="color:#16A34A;"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label">Bulan Ini</div>
                    <div class="stat-value" style="font-size:20px;">Rp {{ number_format($thisMonth, 0, ',', '.') }}</div>
                    @if($lastMonth > 0)
                        @php $change = (($thisMonth - $lastMonth)/$lastMonth)*100; @endphp
                        <span style="font-size:12px;font-weight:600;color:{{ $change >= 0 ? '#DC2626' : '#16A34A' }};">
                            <i class="fas fa-arrow-{{ $change >= 0 ? 'up' : 'down' }}"></i> {{ number_format(abs($change),1) }}% vs bulan lalu
                        </span>
                    @endif
                </div>
                <div class="stat-icon" style="background:#FFF7ED;"><i class="fas fa-calendar-alt" style="color:#EA580C;"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label">Kategori</div>
                    <div class="stat-value">{{ $totalCategories }}</div>
                    <span style="font-size:12px;color:#64748B;">Kategori tersedia</span>
                </div>
                <div class="stat-icon" style="background:#F5F3FF;"><i class="fas fa-tags" style="color:#7C3AED;"></i></div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-lg-8">
        <div class="card-custom">
            <div class="card-header-custom">
                <h6><i class="fas fa-chart-line me-2" style="color:#1565C0;"></i>Tren Pengeluaran 6 Bulan Terakhir</h6>
            </div>
            <div class="p-4">
                <canvas id="monthlyChart" height="100"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card-custom h-100">
            <div class="card-header-custom">
                <h6><i class="fas fa-chart-pie me-2" style="color:#7C3AED;"></i>Per Kategori</h6>
            </div>
            <div class="p-4">
                <canvas id="categoryChart" height="180"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-7">
        <div class="card-custom">
            <div class="card-header-custom">
                <h6><i class="fas fa-clock me-2" style="color:#EA580C;"></i>Pengeluaran Terbaru</h6>
                <a href="{{ route('admin.expenses.index') }}" class="btn btn-sm btn-blue btn-icon" style="width:auto;padding:6px 14px;border-radius:8px;">Lihat Semua</a>
            </div>
            <div class="table-responsive">
                <table class="table table-custom mb-0">
                    <thead>
                        <tr>
                            <th>Pengguna</th>
                            <th>Judul</th>
                            <th>Kategori</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentExpenses as $exp)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <img
                                        src="https://images.unsplash.com/photo-{{ $avatarPhotos[$exp->user->id % count($avatarPhotos)] }}?w=64&h=64&fit=crop&crop=face"
                                        alt="{{ $exp->user->name }}"
                                        style="width:32px;height:32px;border-radius:8px;object-fit:cover;flex-shrink:0;"
                                    >
                                    <div>
                                        <div style="font-size:13px;font-weight:600;color:#1E293B;">{{ Str::limit($exp->user->name,14) }}</div>
                                        <div style="font-size:11px;color:#94A3B8;">{{ $exp->expense_date->format('d M Y') }}</div>
                                    </div>
                                </div>
                            </td>
                            <td style="font-weight:500;">{{ Str::limit($exp->title,20) }}</td>
                            <td>
                                <span class="badge-cat" style="background:{{ $exp->category->color }}20;color:{{ $exp->category->color }};">
                                    {{ $exp->category->name }}
                                </span>
                            </td>
                            <td style="font-weight:700;color:#1565C0;">Rp {{ number_format($exp->amount,0,',','.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card-custom">
            <div class="card-header-custom">
                <h6><i class="fas fa-trophy me-2" style="color:#F59E0B;"></i>Top Pengguna</h6>
                <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-blue btn-icon" style="width:auto;padding:6px 14px;border-radius:8px;">Semua</a>
            </div>
            <div class="p-3">
                @foreach($topUsers as $i => $u)
                <div class="d-flex align-items-center gap-3 p-2 rounded-3 mb-2" style="background:#F8FAFF;">
                    <img
                        src="https://images.unsplash.com/photo-{{ $avatarPhotos[$u->id % count($avatarPhotos)] }}?w=56&h=56&fit=crop&crop=face"
                        alt="{{ $u->name }}"
                        style="width:36px;height:36px;border-radius:10px;object-fit:cover;flex-shrink:0;border:2px solid {{ $i===0?'#F59E0B':($i===1?'#94A3B8':'#CD7C2F') }};"
                    >
                    <div class="flex-grow-1">
                        <div style="font-size:13px;font-weight:600;color:#1E293B;">{{ $u->name }}</div>
                        <div style="font-size:11px;color:#94A3B8;">{{ $u->business_name ?? 'Pengguna' }}</div>
                    </div>
                    <div style="font-size:13px;font-weight:700;color:#1565C0;">Rp {{ number_format($u->expenses_sum_amount??0,0,',','.') }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
const monthlyLabels = {!! json_encode(array_column($monthlyData, 'month')) !!};
const monthlyValues = {!! json_encode(array_column($monthlyData, 'total')) !!};
new Chart(document.getElementById('monthlyChart'), {
    type: 'bar',
    data: {
        labels: monthlyLabels,
        datasets: [{
            label: 'Total Pengeluaran (Rp)',
            data: monthlyValues,
            backgroundColor: 'rgba(21,101,192,0.15)',
            borderColor: '#1565C0',
            borderWidth: 2,
            borderRadius: 8,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero: true, ticks: { callback: v => 'Rp ' + (v/1000000).toFixed(1) + 'Jt' }, grid: { color: '#F1F5F9' } },
            x: { grid: { display: false } }
        }
    }
});

const catLabels = {!! json_encode($categoryData->pluck('name')->toArray()) !!};
const catValues = {!! json_encode($categoryData->pluck('expenses_sum_amount')->toArray()) !!};
new Chart(document.getElementById('categoryChart'), {
    type: 'doughnut',
    data: {
        labels: catLabels,
        datasets: [{
            data: catValues,
            backgroundColor: ['#1565C0','#42A5F5','#16A34A','#EA580C','#7C3AED','#F59E0B'],
            borderWidth: 3, borderColor: '#fff'
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'bottom', labels: { font: { size: 11 }, padding: 12 } }
        }
    }
});
</script>
@endpush
