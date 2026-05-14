@extends('layouts.user')
@section('title', 'Daftar Pengeluaran')
@section('page-title', 'Pengeluaran')
@section('page-subtitle', 'Catat dan kelola pengeluaran usaha Anda')

@section('content')
<div class="card-custom mb-4">
    <div class="card-header-custom">
        <h6><i class="fas fa-filter me-2" style="color:#1565C0;"></i>Cari & Filter</h6>
        <a href="{{ route('user.expenses.create') }}" class="btn-primary-custom" style="font-size:13px;padding:9px 16px;">
            <i class="fas fa-plus"></i> Tambah
        </a>
    </div>
    <div class="p-4">
        <form method="GET" action="{{ route('user.expenses.index') }}">
            <div class="row g-3">
                <div class="col-md-3">
                    <div class="input-group">
                        <span class="input-group-text" style="background:#F8FAFF;border:2px solid #E5E7EB;border-right:none;border-radius:10px 0 0 10px;">
                            <i class="fas fa-search" style="color:#1565C0;"></i>
                        </span>
                        <input type="text" name="search" class="form-control" placeholder="Cari judul..." value="{{ request('search') }}" style="border-left:none;border-radius:0 10px 10px 0;">
                    </div>
                </div>
                <div class="col-md-2">
                    <select name="category_id" class="form-select">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('category_id')==$cat->id?'selected':'' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}" placeholder="Dari tanggal">
                </div>
                <div class="col-md-2">
                    <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}" placeholder="Sampai tanggal">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary-custom w-100"><i class="fas fa-search me-1"></i>Cari</button>
                </div>
                <div class="col-md-1">
                    <a href="{{ route('user.expenses.index') }}" class="btn btn-outline-custom w-100" style="padding:10px 12px;"><i class="fas fa-redo"></i></a>
                </div>
            </div>
        </form>
    </div>
</div>

@if($totalFiltered > 0)
<div class="mb-3 p-3 rounded-3 d-flex align-items-center gap-3" style="background:linear-gradient(135deg,#EFF6FF,#DBEAFE);border:1px solid #BFDBFE;">
    <i class="fas fa-calculator" style="color:#1565C0;font-size:18px;"></i>
    <div>
        <div style="font-size:12px;color:#64748B;font-weight:600;">Total Pengeluaran (filter aktif)</div>
        <div style="font-size:20px;font-weight:800;color:#1565C0;">Rp {{ number_format($totalFiltered,0,',','.') }}</div>
    </div>
</div>
@endif

<div class="card-custom">
    <div class="card-header-custom">
        <h6><i class="fas fa-receipt me-2" style="color:#1565C0;"></i>Daftar Pengeluaran ({{ $expenses->total() }} data)</h6>
    </div>
    <div class="table-responsive">
        <table class="table table-custom mb-0">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Judul</th>
                    <th>Kategori</th>
                    <th>Jumlah</th>
                    <th>Deskripsi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($expenses as $exp)
                <tr>
                    <td style="font-size:13px;color:#64748B;white-space:nowrap;">{{ $exp->expense_date->format('d M Y') }}</td>
                    <td>
                        <div style="font-weight:600;font-size:14px;color:#1E293B;">{{ $exp->title }}</div>
                    </td>
                    <td>
                        <span class="badge-cat" style="background:{{ $exp->category->color }}20;color:{{ $exp->category->color }};border:1px solid {{ $exp->category->color }}40;">
                            <i class="fas fa-circle" style="font-size:7px;margin-right:4px;"></i>{{ $exp->category->name }}
                        </span>
                    </td>
                    <td>
                        <div style="font-weight:800;color:#1565C0;font-size:14px;">Rp {{ number_format($exp->amount,0,',','.') }}</div>
                    </td>
                    <td style="font-size:12px;color:#64748B;max-width:150px;">{{ Str::limit($exp->description??'-',35) }}</td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('user.expenses.edit', $exp) }}" class="btn-icon btn-blue" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form method="POST" action="{{ route('user.expenses.destroy', $exp) }}">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-icon btn-red" title="Hapus"
                                    onclick="return confirm('Hapus pengeluaran ini?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5">
                        <img src="https://images.unsplash.com/photo-1554224155-6726b3ff858f?w=120&h=80&fit=crop" style="width:80px;height:55px;object-fit:cover;border-radius:10px;opacity:0.4;margin-bottom:12px;" alt="">
                        <p style="color:#94A3B8;font-size:14px;margin:0;">Belum ada pengeluaran.</p>
                        <a href="{{ route('user.expenses.create') }}" class="btn-primary-custom mt-3 d-inline-flex" style="font-size:13px;padding:8px 16px;">
                            <i class="fas fa-plus me-1"></i> Tambah Sekarang
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($expenses->hasPages())
    <div class="p-4">{{ $expenses->links() }}</div>
    @endif
</div>
@endsection
