<?php $__env->startSection('title', 'Tambah Pengeluaran'); ?>
<?php $__env->startSection('page-title', 'Tambah Pengeluaran'); ?>
<?php $__env->startSection('page-subtitle', 'Catat pengeluaran baru usaha Anda'); ?>

<?php $__env->startSection('content'); ?>
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card-custom">
            <div class="card-header-custom">
                <h6><i class="fas fa-plus-circle me-2" style="color:#1565C0;"></i>Form Tambah Pengeluaran</h6>
            </div>
            <div class="p-4">
                <div class="mb-4 p-3 rounded-3 d-flex align-items-center gap-3" style="background:#EFF6FF;border-left:4px solid #1565C0;">
                    <img src="https://images.unsplash.com/photo-1563013544-824ae1b704d3?w=60&h=60&fit=crop" style="width:48px;height:48px;border-radius:10px;object-fit:cover;" alt="tip">
                    <div style="font-size:13px;color:#1565C0;">
                        <strong>Tips:</strong> Catat setiap pengeluaran dengan detail agar laporan keuangan usaha Anda lebih akurat dan mudah dianalisis.
                    </div>
                </div>

                <?php if($errors->any()): ?>
                    <div class="alert alert-custom alert-danger-custom mb-4">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <ul class="mb-0 ps-3">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($e); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form method="POST" action="<?php echo e(route('user.expenses.store')); ?>">
                    <?php echo csrf_field(); ?>
                    <div class="row g-4">
                        <div class="col-12">
                            <label class="form-label">Judul Pengeluaran <span style="color:#EF4444;">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text" style="background:#F8FAFF;border:2px solid #E5E7EB;border-right:none;border-radius:10px 0 0 10px;">
                                    <i class="fas fa-file-alt" style="color:#1565C0;"></i>
                                </span>
                                <input type="text" name="title" class="form-control <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    placeholder="cth: Pembelian Bahan Baku, Bayar Listrik..."
                                    value="<?php echo e(old('title')); ?>" required style="border-left:none;border-radius:0 10px 10px 0;">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Jumlah Pengeluaran (Rp) <span style="color:#EF4444;">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text" style="background:#F8FAFF;border:2px solid #E5E7EB;border-right:none;border-radius:10px 0 0 10px;">
                                    <span style="color:#1565C0;font-weight:700;font-size:13px;">Rp</span>
                                </span>
                                <input type="number" name="amount" id="amountInput" class="form-control <?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    placeholder="0" value="<?php echo e(old('amount')); ?>" min="1" step="0.01" required style="border-left:none;border-radius:0 10px 10px 0;">
                            </div>
                            <div id="amountPreview" style="font-size:12px;color:#1565C0;margin-top:4px;font-weight:600;"></div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Tanggal Pengeluaran <span style="color:#EF4444;">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text" style="background:#F8FAFF;border:2px solid #E5E7EB;border-right:none;border-radius:10px 0 0 10px;">
                                    <i class="fas fa-calendar" style="color:#1565C0;"></i>
                                </span>
                                <input type="date" name="expense_date" class="form-control <?php $__errorArgs = ['expense_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    value="<?php echo e(old('expense_date', date('Y-m-d'))); ?>" required style="border-left:none;border-radius:0 10px 10px 0;">
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Kategori <span style="color:#EF4444;">*</span></label>
                            <select name="category_id" class="form-select <?php $__errorArgs = ['category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                <option value="">-- Pilih Kategori --</option>
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($cat->id); ?>" <?php echo e(old('category_id')==$cat->id?'selected':''); ?>>
                                        <?php echo e($cat->name); ?> <?php echo e($cat->is_global ? '(Global)' : '(Pribadi)'); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <div class="mt-2">
                                <a href="<?php echo e(route('user.categories.index')); ?>" style="font-size:12px;color:#1565C0;">
                                    <i class="fas fa-plus-circle me-1"></i> Tambah kategori baru
                                </a>
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Deskripsi (Opsional)</label>
                            <textarea name="description" class="form-control" rows="3"
                                placeholder="Tambahkan keterangan pengeluaran..."><?php echo e(old('description')); ?></textarea>
                        </div>

                        <div class="col-12 d-flex gap-3">
                            <button type="submit" class="btn-primary-custom flex-grow-1">
                                <i class="fas fa-save me-2"></i> Simpan Pengeluaran
                            </button>
                            <a href="<?php echo e(route('user.expenses.index')); ?>" class="btn-outline-custom" style="padding:10px 20px;">
                                <i class="fas fa-times me-1"></i> Batal
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.getElementById('amountInput').addEventListener('input', function() {
    const val = parseFloat(this.value);
    const preview = document.getElementById('amountPreview');
    if (val > 0) {
        preview.textContent = 'Rp ' + val.toLocaleString('id-ID');
    } else {
        preview.textContent = '';
    }
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\budgetly bismillah ga error\resources\views/user/expenses/create.blade.php ENDPATH**/ ?>