@extends('layouts.admin')
@section('title', 'Detail Pengguna')
@section('page-title', 'Detail Pengguna')
@section('page-subtitle', 'Informasi lengkap pengguna')

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
$userAvatarId = $avatarPhotos[$user->id % count($avatarPhotos)];
@endphp

<div class="row g-4">
    <div class="col-lg-4">
        <div class="card-custom mb-4">
            <div class="p-0" style="border-radius:16px 16px 0 0;overflow:hidden;position:relative;">
                <img
                    src="https://images.unsplash.com/photo-1557804506-669a67965ba0?w=600&h=160&fit=crop"
                    alt="cover"
                    style="width:100%;height:100px;object-fit:cover;"
                >
                <div style="position:absolute;bottom:-40px;left:50%;transform:translateX(-50%);">
                    <img
                        src="https://images.unsplash.com/photo-{{ $userAvatarId }}?w=160&h=160&fit=crop&crop=face"
                        alt="{{ $user->name }}"
                        style="width:80px;height:80px;border-radius:20px;object-fit:cover;border:4px solid white;box-shadow:0 4px 12px rgba(0,0,0,0.15);"
                    >
                </div>
            </div>
            <div class="p-4 text-center" style="padding-top:52px !important;">
                <h5 style="font-weight:800;color:#1E293B;margin-bottom:4px;">{{ $user->name }}</h5>
                <p style="color:#64748B;font-size:14px;margin-bottom:12px;">{{ $user->email }}</p>
                <span class="badge-status {{ $user->status==='active'?'badge-active':'badge-inactive' }}">
                    <i class="fas fa-circle" style="font-size:8px;"></i>
                    {{ $user->status==='active'?'Aktif':'Tidak Aktif' }}
                </span>
            </div>
            <div class="p-4" style="border-top:1px solid #F1F5F9;">
                <div class="mb-3">
                    <div style="font-size:12px;color:#94A3B8;font-weight:600;text-transform:uppercase;">Nama Usaha</div>
                    <div style="font-weight:600;color:#1E293B;">{{ $user->business_name ?? '-' }}</div>
                </div>
                <div class="mb-3">
                    <div style="font-size:12px;color:#94A3B8;font-weight:600;text-transform:uppercase;">Telepon</div>
                    <div style="font-weight:600;color:#1E293B;">{{ $user->phone ?? '-' }}</div>
                </div>
                <div class="mb-3">
                    <div style="font-size:12px;color:#94A3B8;font-weight:600;text-transform:uppercase;">Bergabung</div>
                    <div style="font-weight:600;color:#1E293B;">{{ $user->created_at->format('d M Y') }}</div>
                </div>
                <hr>
                <div class="d-flex gap-2">
                    <form method="POST" action="{{ route('admin.users.toggle', $user) }}" class="flex-grow-1">
                        @csrf
                        <button type="submit" class="btn w-100 {{ $user->status==='active'?'btn-danger-custom':'btn-primary-custom' }}" style="font-size:13px;padding:9px;"
                            onclick="return confirm('Ubah status akun ini?')">
                            <i class="fas {{ $user->status==='active'?'fa-ban':'fa-check' }} me-1"></i>
                            {{ $user->status==='active'?'Nonaktifkan':'Aktifkan' }}
                        </button>
                    </form>
                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger-custom" style="font-size:13px;padding:9px 14px;"
                            onclick="return confirm('Hapus akun ini beserta seluruh datanya?')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="card-custom">
            <div class="card-header-custom"><h6><i class="fas fa-chart-bar me-2" style="color:#1565C0;"></i>Statistik</h6></div>
            <div class="p-4">
                <div class="d-flex justify-content-between align-items-center mb-3 p-3 rounded-3" style="background:#F0F7FF;">
                    <span style="font-size:14px;color:#64748B;">Total Pengeluaran</span>
                    <span style="font-weight:800;color:#1565C0;">Rp {{ number_format($totalExpense,0,',','.') }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center p-3 rounded-3" style="background:#F0FDF4;">
                    <span style="font-size:14px;color:#64748B;">Jumlah Transaksi</span>
                    <span style="font-weight:800;color:#16A34A;">{{ $expenses->total() }}</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card-custom">
            <div class="card-header-custom">
                <h6><i class="fas fa-receipt me-2" style="color:#1565C0;"></i>Riwayat Pengeluaran</h6>
            </div>
            <div class="table-responsive">
                <table class="table table-custom mb-0">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Judul</th>
                            <th>Kategori</th>
                            <th>Jumlah</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($expenses as $exp)
                        <tr>
                            <td style="font-size:13px;color:#64748B;">{{ $exp->expense_date->format('d M Y') }}</td>
                            <td>
                                <div style="font-weight:600;font-size:13px;">{{ $exp->title }}</div>
                                @if($exp->description)
                                    <div style="font-size:11px;color:#94A3B8;">{{ Str::limit($exp->description,40) }}</div>
                                @endif
                            </td>
                            <td>
                                <span class="badge-cat" style="background:{{ $exp->category->color }}20;color:{{ $exp->category->color }};">
                                    {{ $exp->category->name }}
                                </span>
                            </td>
                            <td style="font-weight:700;color:#1565C0;">Rp {{ number_format($exp->amount,0,',','.') }}</td>
                            <td>
                                <form method="POST" action="{{ route('admin.expenses.destroy', $exp) }}">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-icon btn-red" title="Hapus"
                                        onclick="return confirm('Hapus pengeluaran ini?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center py-4" style="color:#94A3B8;">Belum ada pengeluaran.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($expenses->hasPages())
            <div class="p-4">{{ $expenses->links() }}</div>
            @endif
        </div>
    </div>
</div>

<a href="{{ route('admin.users.index') }}" class="btn btn-outline-primary-custom mt-4">
    <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar Pengguna
</a>
@endsection
