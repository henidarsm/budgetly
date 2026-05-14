@extends('layouts.user')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Selamat datang, ' . auth()->user()->name . '!')

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

$myAvatarId = $avatarPhotos[auth()->user()->id % count($avatarPhotos)];
@endphp
{{-- Hero banner --}}
<div class="mb-4 p-4 rounded-4 d-flex align-items-center gap-4" style="background:linear-gradient(135deg,#0D47A1,#1565C0,#1976D2);color:white;position:relative;overflow:hidden;">
    <img
    src="https://images.unsplash.com/photo-{{ $myAvatarId }}?w=100&h=100&fit=crop&crop=face"
    alt="{{ auth()->user()->name }}"
    style="width:80px;height:80px;border-radius:18px;object-fit:cover;flex-shrink:0;border:3px solid rgba(255,255,255,0.35);"
/>
    <div class="flex-grow-1">
        <div style="font-size:12px;color:rgba(255,255,255,0.7);text-transform:uppercase;letter-spacing:1px;font-weight:600;">Selamat datang kembali</div>
        <h4 style="font-weight:800;margin:4px 0 8px;">{{ auth()->user()->name }}</h4>
        <div style="font-size:14px;color:rgba(255,255,255,0.8);">{{ auth()->user()->business_name ?? 'Usaha Anda' }}</div>
    </div>
    <div class="d-none d-md-block text-end">
        <div style="font-size:12px;color:rgba(255,255,255,0.7);">Hari ini</div>
        <div style="font-size:18px;font-weight:700;">{{ now()->locale('id')->isoFormat('D MMMM Y') }}</div>
        <a href="{{ route('user.expenses.create') }}" class="btn mt-2" style="background:rgba(255,255,255,0.2);color:white;border-radius:10px;padding:8px 18px;font-size:13px;font-weight:600;border:2px solid rgba(255,255,255,0.4);">
            <i class="fas fa-plus me-1"></i> Tambah Pengeluaran
        </a>
    </div>
</div>

{{-- Stats --}}
<div class="row g-4 mb-4">
    <div class="col-md-3 col-sm-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label">Total Pengeluaran</div>
                    <div class="stat-value" style="font-size:20px;">Rp {{ number_format($totalExpenses, 0, ',', '.') }}</div>
                    <span style="font-size:12px;color:#64748B;">Semua periode</span>
                </div>
                <div class="stat-icon" style="background:#EFF6FF;"><i class="fas fa-wallet" style="color:#1565C0;"></i></div>
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
                        @php $ch = (($thisMonth-$lastMonth)/$lastMonth)*100; @endphp
                        <span style="font-size:12px;font-weight:600;color:{{ $ch>=0?'#DC2626':'#16A34A' }};">
                            <i class="fas fa-arrow-{{ $ch>=0?'up':'down' }}"></i> {{ number_format(abs($ch),1) }}%
                        </span>
                    @else
                        <span style="font-size:12px;color:#64748B;">Bulan ini</span>
                    @endif
                </div>
                <div class="stat-icon" style="background:#FFF7ED;"><i class="fas fa-calendar-check" style="color:#EA580C;"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label">Bulan Lalu</div>
                    <div class="stat-value" style="font-size:20px;">Rp {{ number_format($lastMonth, 0, ',', '.') }}</div>
                    <span style="font-size:12px;color:#64748B;">Perbandingan</span>
                </div>
                <div class="stat-icon" style="background:#F0FDF4;"><i class="fas fa-chart-line" style="color:#16A34A;"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label">Kategori</div>
                    <div class="stat-value">{{ $totalCategories }}</div>
                    <span style="font-size:12px;color:#64748B;">Tersedia</span>
                </div>
                <div class="stat-icon" style="background:#F5F3FF;"><i class="fas fa-tags" style="color:#7C3AED;"></i></div>
            </div>
        </div>
    </div>
</div>

{{-- Charts --}}
<div class="row g-4 mb-4">
    <div class="col-lg-7">
        <div class="card-custom h-100">
            <div class="card-header-custom">
                <h6><i class="fas fa-chart-bar me-2" style="color:#1565C0;"></i>Pengeluaran 6 Bulan Terakhir</h6>
            </div>
            <div class="p-4">
                <canvas id="monthlyChart" height="120"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card-custom h-100">
            <div class="card-header-custom">
                <h6><i class="fas fa-chart-pie me-2" style="color:#7C3AED;"></i>Distribusi Kategori</h6>
            </div>
            <div class="p-3">
                <canvas id="categoryChart" height="160"></canvas>
            </div>
        </div>
    </div>
</div>

{{-- Recent & Top Category --}}
<div class="row g-4">
    <div class="col-lg-7">
        <div class="card-custom">
            <div class="card-header-custom">
                <h6><i class="fas fa-clock me-2" style="color:#EA580C;"></i>Pengeluaran Terbaru</h6>
                <a href="{{ route('user.expenses.index') }}" class="btn-outline-custom" style="font-size:12px;padding:6px 14px;">Lihat Semua</a>
            </div>
            <div class="table-responsive">
                <table class="table table-custom mb-0">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Judul</th>
                            <th>Kategori</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentExpenses as $exp)
                        <tr>
                            <td style="font-size:12px;color:#64748B;white-space:nowrap;">{{ $exp->expense_date->format('d M Y') }}</td>
                            <td style="font-weight:600;font-size:13px;">{{ Str::limit($exp->title,22) }}</td>
                            <td>
                                <span class="badge-cat" style="background:{{ $exp->category->color }}20;color:{{ $exp->category->color }};">
                                    {{ $exp->category->name }}
                                </span>
                            </td>
                            <td style="font-weight:700;color:#1565C0;font-size:13px;white-space:nowrap;">Rp {{ number_format($exp->amount,0,',','.') }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center py-4" style="color:#94A3B8;">Belum ada pengeluaran. <a href="{{ route('user.expenses.create') }}" style="color:#1565C0;">Tambah sekarang</a></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card-custom mb-4">
            <div class="card-header-custom">
                <h6><i class="fas fa-fire me-2" style="color:#EA580C;"></i>Kategori Terbesar</h6>
                <a href="{{ route('user.reports.index') }}" class="btn-outline-custom" style="font-size:12px;padding:6px 14px;">Laporan</a>
            </div>
            <div class="p-4">
                @forelse($topCategories as $cat)
                @php $pct = $totalExpenses > 0 ? ($cat->expenses_sum_amount/$totalExpenses)*100 : 0; @endphp
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span style="font-size:13px;font-weight:600;color:#1E293B;">{{ $cat->name }}</span>
                        <span style="font-size:13px;font-weight:700;color:#1565C0;">Rp {{ number_format($cat->expenses_sum_amount,0,',','.') }}</span>
                    </div>
                    <div style="height:6px;background:#F1F5F9;border-radius:10px;">
                        <div style="height:6px;background:{{ $cat->color }};border-radius:10px;width:{{ $pct }}%;"></div>
                    </div>
                    <div style="font-size:11px;color:#94A3B8;margin-top:2px;">{{ number_format($pct,1) }}% dari total</div>
                </div>
                @empty
                <div class="text-center py-3" style="color:#94A3B8;font-size:14px;">Belum ada data kategori.</div>
                @endforelse
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
const labels = {!! json_encode(array_column($monthlyData, 'month')) !!};
const values = {!! json_encode(array_column($monthlyData, 'total')) !!};
new Chart(document.getElementById('monthlyChart'), {
    type: 'line',
    data: {
        labels,
        datasets: [{
            label: 'Pengeluaran',
            data: values,
            backgroundColor: 'rgba(21,101,192,0.1)',
            borderColor: '#1565C0',
            borderWidth: 2.5,
            tension: 0.4,
            fill: true,
            pointBackgroundColor: '#1565C0',
            pointRadius: 5,
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
const catColors = {!! json_encode($categoryData->pluck('color')->toArray()) !!};
new Chart(document.getElementById('categoryChart'), {
    type: 'doughnut',
    data: {
        labels: catLabels,
        datasets: [{ data: catValues, backgroundColor: catColors, borderWidth: 3, borderColor: '#fff' }]
    },
    options: {
        responsive: true,
        plugins: { legend: { position: 'bottom', labels: { font: { size: 11 }, padding: 10 } } }
    }
});
</script>
@endpush
