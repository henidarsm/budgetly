@extends('layouts.user')
@section('title', 'Edit Pengeluaran')
@section('page-title', 'Edit Pengeluaran')
@section('page-subtitle', 'Perbarui data pengeluaran usaha Anda')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card-custom">
            <div class="card-header-custom">
                <h6><i class="fas fa-edit me-2" style="color:#1565C0;"></i>Edit Pengeluaran</h6>
                <span style="font-size:12px;color:#64748B;">ID #{{ $expense->id }}</span>
            </div>
            <div class="p-4">
                <div class="mb-4 p-3 rounded-3" style="background:#FFF7ED;border-left:4px solid #EA580C;">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fas fa-info-circle" style="color:#EA580C;"></i>
                        <div style="font-size:13px;color:#92400E;">
                            Anda sedang mengedit pengeluaran: <strong>{{ $expense->title }}</strong>
                        </div>
                    </div>
                </div>

                @if($errors->any())
                    <div class="alert alert-custom alert-danger-custom mb-4">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <ul class="mb-0 ps-3">
                            @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('user.expenses.update', $expense) }}">
                    @csrf @method('PUT')
                    <div class="row g-4">
                        <div class="col-12">
                            <label class="form-label">Judul Pengeluaran <span style="color:#EF4444;">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text" style="background:#F8FAFF;border:2px solid #E5E7EB;border-right:none;border-radius:10px 0 0 10px;">
                                    <i class="fas fa-file-alt" style="color:#1565C0;"></i>
                                </span>
                                <input type="text" name="title" class="form-control" value="{{ old('title', $expense->title) }}" required style="border-left:none;border-radius:0 10px 10px 0;">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Jumlah (Rp) <span style="color:#EF4444;">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text" style="background:#F8FAFF;border:2px solid #E5E7EB;border-right:none;border-radius:10px 0 0 10px;">
                                    <span style="color:#1565C0;font-weight:700;font-size:13px;">Rp</span>
                                </span>
                                <input type="number" name="amount" id="amountInput" class="form-control" value="{{ old('amount', $expense->amount) }}" min="1" step="0.01" required style="border-left:none;border-radius:0 10px 10px 0;">
                            </div>
                            <div id="amountPreview" style="font-size:12px;color:#1565C0;margin-top:4px;font-weight:600;">
                                Rp {{ number_format($expense->amount,0,',','.') }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Tanggal <span style="color:#EF4444;">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text" style="background:#F8FAFF;border:2px solid #E5E7EB;border-right:none;border-radius:10px 0 0 10px;">
                                    <i class="fas fa-calendar" style="color:#1565C0;"></i>
                                </span>
                                <input type="date" name="expense_date" class="form-control" value="{{ old('expense_date', $expense->expense_date->format('Y-m-d')) }}" required style="border-left:none;border-radius:0 10px 10px 0;">
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Kategori <span style="color:#EF4444;">*</span></label>
                            <select name="category_id" class="form-select" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ (old('category_id', $expense->category_id)==$cat->id)?'selected':'' }}>
                                        {{ $cat->name }} {{ $cat->is_global ? '(Global)' : '(Pribadi)' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Deskripsi (Opsional)</label>
                            <textarea name="description" class="form-control" rows="3">{{ old('description', $expense->description) }}</textarea>
                        </div>

                        <div class="col-12 d-flex gap-3">
                            <button type="submit" class="btn-primary-custom flex-grow-1">
                                <i class="fas fa-save me-2"></i> Simpan Perubahan
                            </button>
                            <a href="{{ route('user.expenses.index') }}" class="btn-outline-custom" style="padding:10px 20px;">
                                <i class="fas fa-times me-1"></i> Batal
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('amountInput').addEventListener('input', function() {
    const val = parseFloat(this.value);
    const preview = document.getElementById('amountPreview');
    preview.textContent = val > 0 ? 'Rp ' + val.toLocaleString('id-ID') : '';
});
</script>
@endpush
