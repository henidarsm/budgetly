@extends('layouts.admin')
@section('title', 'Semua Pengeluaran')
@section('page-title', 'Semua Pengeluaran')
@section('page-subtitle', 'Monitor seluruh pengeluaran pengguna')

@section('content')
<div class="card-custom mb-4">
    <div class="card-header-custom">
        <h6><i class="fas fa-filter me-2" style="color:#1565C0;"></i>Filter Pengeluaran</h6>
    </div>
    <div class="p-4">
        <form method="GET" action="{{ route('admin.expenses.index') }}">
            <div class="row g-3">
                <div class="col-md-3">
                    <input type="text" name="search" class="form-control" placeholder="Cari judul..." value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <select name="user_id" class="form-select">
                        <option value="">Semua Pengguna</option>
                        @foreach($users as $u)
                            <option value="{{ $u->id }}" {{ request('user_id')==$u->id?'selected':'' }}>{{ $u->name }}</option>
                        @endforeach
                    </select>
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
                <div class="col-md-1">
                    <button type="submit" class="btn btn-primary-custom w-100"><i class="fas fa-search"></i></button>
                </div>
            </div>
            @if(request()->hasAny(['search','user_id','category_id','date_from','date_to']))
            <div class="mt-2">
                <a href="{{ route('admin.expenses.index') }}" class="btn btn-sm" style="color:#64748B;font-size:13px;"><i class="fas fa-times me-1"></i>Reset Filter</a>
            </div>
            @endif
        </form>
    </div>
</div>

<div class="card-custom">
    <div class="card-header-custom">
        <h6><i class="fas fa-receipt me-2" style="color:#1565C0;"></i>Daftar Pengeluaran ({{ $expenses->total() }} data)</h6>
        <div style="background:#EFF6FF;padding:8px 16px;border-radius:10px;font-size:13px;font-weight:700;color:#1565C0;">
            Total: Rp {{ number_format($expenses->sum('amount'),0,',','.') }}
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-custom mb-0">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Pengguna</th>
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
                        <div style="font-size:13px;font-weight:600;color:#1E293B;">{{ $exp->user->name }}</div>
                        <div style="font-size:11px;color:#94A3B8;">{{ $exp->user->business_name ?? '-' }}</div>
                    </td>
                    <td style="font-weight:600;font-size:13px;">{{ $exp->title }}</td>
                    <td>
                        <span class="badge-cat" style="background:{{ $exp->category->color }}20;color:{{ $exp->category->color }};">
                            {{ $exp->category->name }}
                        </span>
                    </td>
                    <td style="font-weight:700;color:#1565C0;white-space:nowrap;">Rp {{ number_format($exp->amount,0,',','.') }}</td>
                    <td style="font-size:12px;color:#64748B;">{{ Str::limit($exp->description??'-',30) }}</td>
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
                <tr>
                    <td colspan="7" class="text-center py-5">
                        <i class="fas fa-receipt" style="font-size:48px;color:#CBD5E1;"></i>
                        <p class="mt-3" style="color:#94A3B8;">Tidak ada data pengeluaran.</p>
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
