@extends('layouts.admin')
@section('title', 'Kategori Global')
@section('page-title', 'Kategori Global')
@section('page-subtitle', 'Kelola kategori yang tersedia untuk semua pengguna')

@section('content')
<div class="row g-4">
    <div class="col-lg-4">
        <div class="card-custom">
            <div class="card-header-custom">
                <h6><i class="fas fa-plus-circle me-2" style="color:#1565C0;"></i>Tambah Kategori Global</h6>
            </div>
            <div class="p-4">
                @if($errors->any())
                    <div class="alert-custom alert-danger-custom mb-3 p-3 rounded-3">
                        @foreach($errors->all() as $e)<div><i class="fas fa-times me-1"></i>{{ $e }}</div>@endforeach
                    </div>
                @endif
                <form method="POST" action="{{ route('admin.categories.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Nama Kategori <span style="color:#EF4444;">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="cth: Bahan Baku, Gaji..." value="{{ old('name') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Warna</label>
                        <div class="d-flex align-items-center gap-3">
                            <input type="color" name="color" class="form-control" value="{{ old('color', '#1565C0') }}" style="width:60px;height:42px;padding:4px;cursor:pointer;border-radius:10px;">
                            <span style="font-size:13px;color:#64748B;">Pilih warna label</span>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Deskripsi (Opsional)</label>
                        <textarea name="description" class="form-control" rows="2" placeholder="Keterangan kategori...">{{ old('description') }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary-custom w-100">
                        <i class="fas fa-plus me-2"></i> Tambah Kategori Global
                    </button>
                </form>
            </div>
        </div>
        <div class="card-custom mt-4">
            <div class="p-0">
                <img src="https://images.unsplash.com/photo-1607863680198-23d4b2565df0?w=400&h=160&fit=crop" alt="categories" style="width:100%;height:130px;object-fit:cover;border-radius:16px 16px 0 0;">
                <div class="p-4">
                    <p style="font-size:13px;color:#64748B;line-height:1.7;margin:0;">Kategori global tersedia untuk semua pengguna. Gunakan untuk kategori umum seperti Bahan Baku, Gaji, Utilitas, dll.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card-custom">
            <div class="card-header-custom">
                <h6><i class="fas fa-globe me-2" style="color:#7C3AED;"></i>Daftar Kategori Global ({{ $categories->total() }})</h6>
            </div>
            <div class="table-responsive">
                <table class="table table-custom mb-0">
                    <thead>
                        <tr>
                            <th>Kategori</th>
                            <th>Warna</th>
                            <th>Deskripsi</th>
                            <th>Jml Pengeluaran</th>
                            <th>Tipe</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $cat)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div style="width:36px;height:36px;background:{{ $cat->color }}20;border-radius:10px;display:flex;align-items:center;justify-content:center;border:2px solid {{ $cat->color }}40;">
                                        <i class="fas fa-tag" style="color:{{ $cat->color }};font-size:14px;"></i>
                                    </div>
                                    <span style="font-weight:700;font-size:14px;">{{ $cat->name }}</span>
                                </div>
                            </td>
                            <td>
                                <div style="display:flex;align-items:center;gap:8px;">
                                    <div style="width:24px;height:24px;background:{{ $cat->color }};border-radius:6px;"></div>
                                    <span style="font-size:12px;color:#64748B;font-family:monospace;">{{ $cat->color }}</span>
                                </div>
                            </td>
                            <td style="font-size:13px;color:#64748B;">{{ Str::limit($cat->description??'-',30) }}</td>
                            <td>
                                <span style="background:#EFF6FF;color:#1565C0;padding:4px 12px;border-radius:20px;font-size:12px;font-weight:600;">
                                    {{ $cat->expenses_count }}
                                </span>
                            </td>
                            <td>
                                @if($cat->is_global)
                                    <span class="badge-status badge-admin"><i class="fas fa-globe" style="font-size:9px;"></i> Global</span>
                                @else
                                    <span class="badge-status badge-user"><i class="fas fa-user" style="font-size:9px;"></i> Pribadi</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <button class="btn-icon btn-blue" onclick="openEditModal({{ $cat->id }}, '{{ addslashes($cat->name) }}', '{{ $cat->color }}', '{{ addslashes($cat->description??'') }}')" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    @if($cat->expenses_count == 0)
                                    <form method="POST" action="{{ route('admin.categories.destroy', $cat) }}">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn-icon btn-red" title="Hapus"
                                            onclick="return confirm('Hapus kategori ini?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    @else
                                    <span class="btn-icon" style="background:#F1F5F9;color:#CBD5E1;cursor:not-allowed;" title="Tidak bisa dihapus, masih digunakan">
                                        <i class="fas fa-trash"></i>
                                    </span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <i class="fas fa-tags" style="font-size:48px;color:#CBD5E1;"></i>
                                <p class="mt-3" style="color:#94A3B8;">Belum ada kategori. Tambahkan dari form sebelah.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($categories->hasPages())
            <div class="p-4">{{ $categories->links() }}</div>
            @endif
        </div>
    </div>
</div>

{{-- Edit Modal --}}
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius:16px;border:none;box-shadow:0 20px 60px rgba(0,0,0,0.2);">
            <div class="modal-header" style="border-bottom:1px solid #F1F5F9;padding:20px 24px;">
                <h5 style="font-weight:700;color:#1E293B;margin:0;"><i class="fas fa-edit me-2" style="color:#1565C0;"></i>Edit Kategori</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" id="editForm">
                @csrf @method('PUT')
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label">Nama Kategori</label>
                        <input type="text" name="name" id="editName" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Warna</label>
                        <input type="color" name="color" id="editColor" class="form-control" style="width:80px;height:42px;padding:4px;border-radius:10px;cursor:pointer;">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="description" id="editDesc" class="form-control" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer" style="border-top:1px solid #F1F5F9;padding:16px 24px;">
                    <button type="button" class="btn btn-outline-primary-custom" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary-custom"><i class="fas fa-save me-1"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function openEditModal(id, name, color, desc) {
    document.getElementById('editForm').action = '/admin/categories/' + id;
    document.getElementById('editName').value = name;
    document.getElementById('editColor').value = color;
    document.getElementById('editDesc').value = desc;
    new bootstrap.Modal(document.getElementById('editModal')).show();
}
</script>
@endpush
