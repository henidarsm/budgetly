@extends('layouts.admin')
@section('title', 'Data Pengguna')
@section('page-title', 'Data Pengguna')
@section('page-subtitle', 'Kelola seluruh akun pengguna sistem')

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

<div class="card-custom mb-4">
    <div class="card-header-custom">
        <h6><i class="fas fa-users me-2" style="color:#1565C0;"></i>Filter & Pencarian</h6>
    </div>
    <div class="p-4">
        <form method="GET" action="{{ route('admin.users.index') }}">
            <div class="row g-3">
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-text" style="background:#F8FAFF;border:2px solid #E5E7EB;border-right:none;border-radius:10px 0 0 10px;">
                            <i class="fas fa-search" style="color:#1565C0;"></i>
                        </span>
                        <input type="text" name="search" class="form-control" placeholder="Cari nama, email, atau usaha..." value="{{ request('search') }}" style="border-left:none;border-radius:0 10px 10px 0;">
                    </div>
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="active" {{ request('status')=='active'?'selected':'' }}>Aktif</option>
                        <option value="inactive" {{ request('status')=='inactive'?'selected':'' }}>Tidak Aktif</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary-custom w-100"><i class="fas fa-search me-1"></i>Cari</button>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-primary-custom w-100"><i class="fas fa-redo me-1"></i>Reset</a>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card-custom">
    <div class="card-header-custom">
        <h6><i class="fas fa-list me-2" style="color:#1565C0;"></i>Daftar Pengguna ({{ $users->total() }} data)</h6>
    </div>
    <div class="table-responsive">
        <table class="table table-custom mb-0">
            <thead>
                <tr>
                    <th>Pengguna</th>
                    <th>Usaha</th>
                    <th>Telepon</th>
                    <th>Total Pengeluaran</th>
                    <th>Jml Transaksi</th>
                    <th>Status</th>
                    <th>Bergabung</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <img
                                src="https://images.unsplash.com/photo-{{ $avatarPhotos[$user->id % count($avatarPhotos)] }}?w=76&h=76&fit=crop&crop=face"
                                alt="{{ $user->name }}"
                                style="width:38px;height:38px;border-radius:10px;object-fit:cover;flex-shrink:0;"
                            >
                            <div>
                                <div style="font-weight:600;color:#1E293B;font-size:14px;">{{ $user->name }}</div>
                                <div style="font-size:12px;color:#64748B;">{{ $user->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td style="font-size:13px;">{{ $user->business_name ?? '-' }}</td>
                    <td style="font-size:13px;">{{ $user->phone ?? '-' }}</td>
                    <td style="font-weight:700;color:#1565C0;font-size:13px;">Rp {{ number_format($user->expenses_sum_amount??0,0,',','.') }}</td>
                    <td>
                        <span style="background:#EFF6FF;color:#1565C0;padding:4px 10px;border-radius:20px;font-size:12px;font-weight:600;">
                            {{ $user->expenses_count }} transaksi
                        </span>
                    </td>
                    <td>
                        <span class="badge-status {{ $user->status==='active' ? 'badge-active' : 'badge-inactive' }}">
                            <i class="fas fa-circle" style="font-size:8px;"></i>
                            {{ $user->status==='active' ? 'Aktif' : 'Tidak Aktif' }}
                        </span>
                    </td>
                    <td style="font-size:13px;color:#64748B;">{{ $user->created_at->format('d M Y') }}</td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.users.show', $user) }}" class="btn-icon btn-blue" title="Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.users.toggle', $user) }}">
                                @csrf
                                <button type="submit" class="btn-icon {{ $user->status==='active'?'btn-orange':'btn-green' }}"
                                    title="{{ $user->status==='active'?'Nonaktifkan':'Aktifkan' }}"
                                    onclick="return confirm('{{ $user->status==='active'?'Nonaktifkan':'Aktifkan' }} pengguna ini?')">
                                    <i class="fas {{ $user->status==='active'?'fa-ban':'fa-check' }}"></i>
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-icon btn-red" title="Hapus"
                                    onclick="return confirm('Hapus akun {{ $user->name }}? Semua data pengeluarannya akan ikut terhapus!')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-5">
                        <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=120&h=80&fit=crop" style="width:80px;height:55px;object-fit:cover;border-radius:10px;opacity:0.4;margin-bottom:12px;" alt="">
                        <p style="color:#94A3B8;">Tidak ada pengguna ditemukan.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($users->hasPages())
    <div class="p-4">{{ $users->links() }}</div>
    @endif
</div>
@endsection
